<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mutiple Images
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                <div class="col-md-8">
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session('success') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="card-group">
                        @foreach($images as $multiple)
                        <div class="col-md-4 mt-5">
                            <div class="card">
                                <img src="{{ asset($multiple->image) }}" alt="">
                            </div>
                        </div>
                        @endforeach
                    </div>                 
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Add Images</div>
                        <div class="card-body">
                            <form action="{{ route('store.multipictures') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 form-group">
                                    <label for="exampleInputEmail1" class="form-label">Images</label>
                                    <input type="file" name="image[]" class="form-control" id="exampleInputEmail1" 
                                        aria-describedby="emailHelp" multiple>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add Images</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
