@extends('admin.admin_master')
@section('admin')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-12">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            All Jobs
                        </div>
                        <div class="container mt-5">
                        <div class="card-body">
                            <form action="{{ url('category/job') }}"  enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Upload Category List</label>
                                        <input type="file" name="category_upload" class="form-control" id="exampleInputEmail1"
                                            aria-describedby="emailHelp">
                                        @error('category_upload')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <button type="submit" class="btn btn-primary">Upload Category</button>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
