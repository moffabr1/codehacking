@extends('layouts.admin')






@section('content')

    @if(Session::has('message'))

        <p class="bg-danger">{{session('message')}}</p>


    @endif

    <h1>Posts</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Id</th>
                <th>Photo</th>
                <th>Owner</th>
                <th>Category</th>
                <th>Title</th>
                <th>Body</th>
                <th>Post</th>
                <th>Comments</th>
                <th>Created</th>
                <th>Updated</th>
            </tr>
        </thead>
        <tbody>

        @if($posts)

            @foreach($posts as $post)


            <tr>
                <td>{{$post->id}}</td>
                <td><img height="100" width="100" src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/100x100' }}" alt=""></td>
                <td>{{$post->user->name}}</td>
                <td>{{$post->category ? $post->category->name : 'Uncategorized'}}</td>
                <td><a href="{{route('admin.posts.edit', $post->id)}}">{{$post->title}}</a></td>
                {{--<td>{{$post->title}}</td>--}}
                <td>{{$post->body}}</td>
                <td><a href="{{route('home.post', $post->slug)}}">View Post</a></td>
                {{--<td><a href="{{route('home.post', $post->id)}}">View Post</a></td>--}}
                <td><a href="{{route('admin.comments.show', $post->id)}}">View Comments</a></td>
                <td>{{$post->created_at->diffForHumans()}}</td>
                <td>{{$post->updated_at->diffForHumans()}}</td>
            </tr>


            @endforeach

        @endif


        </tbody>
      </table>


    <div class="row">
        <div class="col-sm-6 col-sm-offset-5">

            {{$posts->render()}}

        </div>
    </div>


 @stop