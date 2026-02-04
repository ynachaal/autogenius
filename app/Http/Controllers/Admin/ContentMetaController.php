<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContentMeta;
use App\Models\Page; // Import Page Model
use Illuminate\Support\Facades\File;
use enshrined\svgSanitize\Sanitizer;

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
        $request->validate([
            'meta' => 'required|array',
        ]);

        // 1. Save Text Inputs
        foreach ($request->input('meta') as $key => $value) {
            ContentMeta::updateOrCreate(
                ['meta_key' => $section . '_' . $key],
                ['meta_value' => $value ?? '']
            );
        }

        // 2. Handle Files inside the meta array
        if ($request->hasFile('meta')) {
            $files = $request->file('meta');
            $destinationPath = public_path('uploads/meta');
            $sanitizer = new Sanitizer(); // Initialize once outside the loop

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            foreach ($files as $key => $file) {
                if ($file->isValid()) {
                    $metaKey = $section . '_' . $key;
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time() . '_' . $file->getClientOriginalName();

                    // --- CLEAN UP OLD FILE START ---
                    $oldMeta = ContentMeta::where('meta_key', $metaKey)->first();
                    if ($oldMeta && $oldMeta->meta_value && File::exists(public_path($oldMeta->meta_value))) {
                        File::delete(public_path($oldMeta->meta_value));
                    }
                    // --- CLEAN UP OLD FILE END ---

                    // --- SECURE SVG LOGIC ---
                    if ($extension === 'svg') {
                        $content = file_get_contents($file->getRealPath());
                        $cleanSvg = $sanitizer->sanitize($content);
                        
                        File::put($destinationPath . '/' . $fileName, $cleanSvg);
                    } else {
                        $file->move($destinationPath, $fileName);
                    }

                    // Save the path to the database
                    ContentMeta::updateOrCreate(
                        ['meta_key' => $metaKey],
                        ['meta_value' => 'uploads/meta/' . $fileName]
                    );
                }
            }
        }

        return redirect()->back()->with('success', ucfirst($section) . ' Meta Saved Successfully');
    }
}