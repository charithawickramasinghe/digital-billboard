<x-layout>

    <div class="content">
        <div class="card">
            <h4 class="card-header">Screen {{ $screen_id }}</h4>

            <div class="card-body">

                @session('success')
                <div class="alert alert-success">
                    {{ $value }}
                </div>
                @endsession

                @foreach ($images as $image)
                    <div class="d-inline-block text-center m-2">
                        <img src="/images/{{ $image->name }}" class="p-2" style="width: 200px">

                        <form action="{{ route('image.delete', $image->id) }}" method="POST"
                              onsubmit="return confirm('Delete this image?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                @endforeach

                <form action="{{route('image.upload.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="imputName">Choose Image :</label>
                        <input type="file" name="images[]" id="inputName" multiple class="form-control @error('name') is-invalid @enderror " />
                        @error('images')
                        <spam class="text-danger">{{ $message }}</spam>
                        @enderror
                    </div>

                    <input type="hidden" name="screen_id" value="{{ $screen_id }}">

                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</x-layout>
