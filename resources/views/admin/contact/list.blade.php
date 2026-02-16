@extends('admin.layout.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="heading-section">Contacts</h2>
        </div>

        <a href="{{ route('admin#home') }}" class="text-primary">
            <h5> <<-Back </h5>
        </a>

        <table class="table table-hover shadow-sm mt-2">
            <thead class="bg-primary text-white">
                <tr>
                    <th>Phone</th>
                    <th>Profile</th>
                    <th>Email</th>
                    <th>Title</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $item)
                    <tr>
                        <td>{{ $item->phone }}</td>
                        <td><img class="rounded-circle w-25"
                                src="{{ asset($item->profile == null ? 'default_image/defaultProfile.jpg' : 'userProfile/' . $item->profile) }}">
                        </td>
                        <td>{{ $item->user_email }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->message }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <span>{{ $contacts->links() }}</span>

    </div>
@endsection
