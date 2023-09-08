<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- Letakkan di sini -->
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<body class="bg-light">
    <main class="container">
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <div class="my-3 p-3 bg-body rounded shadow-sm" id="alert" style="display: none;">
                    <p>Berhasil</p>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $item)
                            <li>{{$item}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{session('success')}}
                </div>
            @endif
            @if (session()->has('delete'))
                <div class="alert alert-danger">
                    {{session('delete')}}
                </div>
            @endif

            <form action='' method='post'>
                @csrf
                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='judul' id="judul" value="{{old('judul')}}" pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pengarang" class="col-sm-2 col-form-label">Pengarang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='pengarang' id="pengarang" value="{{old('pengarang')}}" pattern="[A-Za-z\s]+" title="Hanya huruf dan spasi yang diperbolehkan">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal_publikasi" class="col-sm-2 col-form-label">Tanggal Publikasi</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control w-50" name='tanggal_publikasi' id="tanggal_publikasi" value="{{old('tanggal_publikasi')}}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">SIMPAN</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4">Judul</th>
                        <th class="col-md-3">Pengarang</th>
                        <th class="col-md-2">Tanggal Publikasi</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i=$data ['from'];?>
                    @foreach ($data ['data'] as $item)
                    <tr>
                        <td>{{$i}} </td>
                        <td>{{$item['judul']}} </td>
                        <td>{{$item['pengarang']}}  </td>
                        <td>{{date('d/m/Y',strtotime($item['tanggal_publikasi']))}} </td>
                        <td>
                            <a href="#" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{$item['id']}}">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item['id']}}">Delete</button>
                        </td>
                    </tr>
                    <div class="modal fade" id="deleteModal{{$item['id']}}" tabindex="-1" aria-labelledby="deleteModalLabel{{$item['id']}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel{{$item['id']}}">Konfirmasi Hapus Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah Anda yakin ingin menghapus data ini?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form action="{{ route('buku.destroy', $item['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Edit -->
     <div class="modal fade" id="editModal{{$item['id']}}" tabindex="-1" aria-labelledby="editModalLabel{{$item['id']}}" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel{{$item['id']}}">Edit Data Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('buku.update', $item['id']) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="edit-judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="edit-judul" name="edit_judul" value="{{ $item['judul'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-pengarang" class="form-label">Pengarang</label>
                        <input type="text" class="form-control" id="edit-pengarang" name="edit_pengarang" value="{{ $item['pengarang'] }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-tanggal" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control" id="edit-tanggal" name="edit_tanggal_publikasi" value="{{ $item['tanggal_publikasi'] }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
<!-- Modal Edit End -->
                    </div>
                    <?php $i++  ?>
                    @endforeach
                </tbody>
            </table>
            @if ($data['links'])
            <nav aria-label="...">
                <ul class="pagination">
                    @foreach ($data['links'] as $item)
                    <li class="page-item {{$item['active']?'active':''}}"><a class="page-link" href="{{$item['url2']}}">{!! $item['label']!!} </a></li>        
                    @endforeach   
                </ul>
            </nav>
            @endif
        </div>
    </main>
       
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap (popper.js) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.1/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSn5c6w0k1mkF5j5p5F5" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.1/js/bootstrap.min.js" integrity="sha384-rsi5SO5Kxi5FfD9b4lRa4ZwtkBfI5Jf5Pge84fR5/kzpk5aqtnZrGs3raIvm2cKx" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap (popper.js) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.1/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSn5c6w0k1mkF5j5p5F5" crossorigin="anonymous"></script>
    <!-- JavaScript Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.2.1/js/bootstrap.min.js" integrity="sha384-rsi5SO5Kxi5FfD9b4lRa4ZwtkBfI5Jf5Pge84fR5/kzpk5aqtnZrGs3raIvm2cKx" crossorigin="anonymous"></script>

    
</body>
    


</html>