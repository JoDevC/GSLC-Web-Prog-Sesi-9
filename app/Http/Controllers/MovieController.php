<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');

        $movies = Movie::with('genre')->when($search, function($query, $search) {
            return $query->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhereHas('genre', function($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                });
        })->paginate(4);

        return view('movies.index', compact('movies'));
    }

    public function create(){
        $genres = Genre::all();
        return view('movies.create', compact('genres'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), 
            [
                'genre_id' => 'required|exists:genres,id',
                'photo' => 'required|Image|max:5120',
                'title' => 'required|max:30',
                'description' => 'required|max:50',
                'publish_date' => 'required|date|before_or_equal:today'
            ],
            [
                'genre_id.required' => 'Silahkan Pilih Genre',
                'photo.required' => 'Silahkan Masukkan Foto',
                'photo.Image' => 'Gunakan Format Gambar yang Diperbolehkan',
                'photo.max' => 'Ukuran Foto Maksimal 5MB',
                'title.required' => 'Silahkan Masukkan Judul',
                'title.max' => 'Judul Maksimal 30 Karakter',
                'description.required' => 'Silahkan Masukkan Deskripsi',
                'description.max' => 'Deskripsi Maksimal 50 Karakter',
                'publish_date.required' => 'Silahkan Masukkan Tanggal',
                'publish_date.date' => 'Masukkan Tanggal yang Valid',
                'publish_date.before_or_equal' => 'Tidak Boleh Lebih Dari Hari Ini'
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('movies.create')->withErrors($validator)->withInput()->with('custom_errors', $validator->errors()->all());
        }

        try {
            $photo = $request->file('photo')->store('photos', 'public');

            Movie::create([
                'genre_id' => $request->genre_id,
                'photo' => $photo,
                'title' => $request->title,
                'description' => $request->description,
                'publish_date' => $request->publish_date
            ]);
            return redirect()->route('movies.index')->with('success', 'Movie Berhasil Ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('movies.create')->with('error', 'Gagal Menambahkan Movie');
        }
    }

    public function destroy(Movie $movie){
        if (Storage::disk('public')->exists($movie->photo)) {
            Storage::disk('public')->delete($movie->photo);
        }
        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Movie Berhasil Dihapus');
    }
}
