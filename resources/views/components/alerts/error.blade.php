@if(Session::has('errors'))
    @if($errors->all())
        <script type="text/javascript">
            Alert.fire({
                icon: 'error',
                title: 'Error/s had been encountered while processing your request',
                html: '' +
                    '@foreach($errors->all() as $error)' +
                    '   <ul>' +
                    '      {{ $error }}' +
                    '   </ul>' +
                    '@endforeach',
            });
        </script>
    @endif
@endif
