<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContentMeta;
use App\Models\Page; // Import Page Model
use Illuminate\Support\Facades\File;

class ContentMetaController extends Controller
{
    public function index($section = 'default')
    {
        $meta = ContentMeta::where('meta_key', 'like', $section . '_%')
            ->get()
            ->keyBy('meta_key');

        $pages = Page::orderBy('title')->get();

        // Convert section slug to view name
        $view = 'admin.content-meta.' . $section;

        // If section-specific view exists, load it
        if (view()->exists($view)) {
            return view($view, compact('meta', 'section', 'pages'));
        }

        // Fallback
        return view('admin.content-meta.index', compact('meta', 'section', 'pages'));
    }


    public function saveMeta(Request $request, $section = 'default')
    {
        // 1. Validate (Note: validating array files can be tricky, kept simple here)
        $request->validate([
            'meta' => 'required|array',
        ]);

        // 2. Save Text Inputs
        foreach ($request->input('meta') as $key => $value) {
            // We skip processing if it's meant to be a file; handled below
            ContentMeta::updateOrCreate(
                ['meta_key' => $section . '_' . $key],
                ['meta_value' => $value ?? '']
            );
        }

        // 3. Handle Files inside the meta array
        if ($request->hasFile('meta')) {
            $files = $request->file('meta');
            $destinationPath = public_path('uploads/meta');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            foreach ($files as $key => $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move($destinationPath, $fileName);

                    // Save the path to the database
                    ContentMeta::updateOrCreate(
                        ['meta_key' => $section . '_' . $key],
                        ['meta_value' => 'uploads/meta/' . $fileName]
                    );
                }
            }
        }

        return redirect()->back()->with('success', ucfirst($section) . ' Meta Saved Successfully');
    }
}