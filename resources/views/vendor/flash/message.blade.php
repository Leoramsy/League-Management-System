@foreach (session('flash_notification', collect())->toArray() as $message)
    @if ($message['overlay'])
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => $message['title'],
            'body'       => $message['message']
        ])
    @else
    <script>
        flash_message("{!! $message['message'] !!}", "{!! $message['level'] !!}", "{!! $message['important'] !!}");       
        </script>        
    @endif
@endforeach

{{ session()->forget('flash_notification') }}
