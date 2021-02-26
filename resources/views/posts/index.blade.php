@extends('layouts.app')

@section('content')
    <div class="flex justify-center mb-4">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <form action="{{ route('posts') }}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="body" class="sr-only">Body</label>
                    <textarea class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror "
                        name="body" id="body" cols="3" placeholder="Write something!"></textarea>
                    @error('body')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded font-medium">
                        Post
                    </button>
                </div>
            </form>


            @if ($posts->count())

                @foreach ($posts as $post)

                    <div class="mb-4">
                        <a href="" class="font-bold"> {{ $post->user->username }} </a> <span class="text-gray-600 text-sm">
                            {{ $post->created_at->diffForHumans() }} </span>

                        <p class="mb-2">
                            {{ $post->body }}
                        </p>

                        <div class="flex items-center">
                            <span class="mr-1"> {{ $post->likes->count() }}
                                {{ Str::plural('like', $post->likes->count()) }} </span>
                            @auth
                                @if ($post->likes->count())
                                    <span class="mr-1"> {{ $post->likes->count() }}
                                        {{ Str::plural('like', $post->likes->count()) }} </span>

                                @endif

                                @if (!$post->likedBy(auth()->user()))
                                    <form class="mr-1" action="{{ route('posts.likes', $post) }}" method="POST">
                                        @csrf
                                        <button class="text-blue-500" type="submit">Like</button>

                                    </form>
                                @else

                                    <form class="mr-1" action="{{ route('posts.unlikes', $post) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-blue-500" type="submit">Unlike</button>
                                    </form>
                                @endif

                                @if ($post->isOwnedPost(auth()->user()))
                                <form action="{{route('posts.delete', $post)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-blue-500">Delete</button>
                                </form>
                                @endif


                            @endauth
                        </div>


                    </div>

                @endforeach

                {{ $posts->links() }}

            @else
                <h3 class="text-center">There are no posts</h3>
            @endif


        </div>

    </div>

@endsection
