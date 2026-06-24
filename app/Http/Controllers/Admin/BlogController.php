<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(15);
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.form');
    }

    public function store(Request $request)
    {
        $validated = $this->validateBlog($request);
        $validated['slug'] = Str::slug($validated['judul']);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('blog', 'public');
        }

        Blog::create($validated);
        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.form', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $this->validateBlog($request);

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail) Storage::disk('public')->delete($blog->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('blog', 'public');
        }

        $blog->update($validated);
        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail) Storage::disk('public')->delete($blog->thumbnail);
        $blog->delete();
        return redirect()->route('admin.blog.index')->with('success', 'Artikel berhasil dihapus!');
    }

    private function validateBlog(Request $request): array
    {
        // Strip HTML tags untuk cek apakah isi benar-benar ada teksnya
        $isiRaw   = $request->input('isi', '');
        $isiStrip = trim(strip_tags($isiRaw));

        // Kalau isi kosong atau cuma whitespace/HTML kosong, set ke null agar validasi 'required' gagal dengan pesan yang benar
        if ($isiStrip === '') {
            $request->merge(['isi' => null]);
        }

        return $request->validate([
            'judul'       => 'required|string|max:255',
            'isi'         => 'required|string',
            'kategori'    => 'nullable|string|max:100',
            'penulis'     => 'nullable|string|max:100',
            'thumbnail'   => 'nullable|image|max:2048',
            'is_featured' => 'boolean',
        ]);
    }
}
