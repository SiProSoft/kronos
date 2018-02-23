<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{--  CSRF Token  --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{--  Styles  --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/datetimepicker.min.css') }}">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body>
    <div id="app">

        @include('inc.nav')

        <div class="container">
            @include('inc.messages')
        </div>

        
        @yield('content')

        @auth
            @include('inc.floating-timer-button')
        @endauth
    </div>

    
    {{--  Scripts   --}}
    <script src="{{ asset('js/app.js') }}"></script>

    {{--  CDN  --}}
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/locale/fo.js"></script>

    {{--  Plugins  --}}
    <script src="{{ asset('js/datetimepicker.min.js') }}"></script>


    {{--  DateTime Picker code  --}}
    <script type="text/javascript">

        $(function () {
            var d6 = $('#datetimepicker6').data('default-date');
            var d7 = $('#datetimepicker7').data('default-date');

            $('#datetimepicker6').datetimepicker({
                defaultDate: d6,
                format: 'YYYY-MM-DD HH:mm:ss',
            });
            $('#datetimepicker7').datetimepicker({
                defaultDate: d7,
                format: 'YYYY-MM-DD HH:mm:ss',
                useCurrent: false //Important! See issue #1075
            });
            $("#datetimepicker6").on("dp.change", function (e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function (e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });

            $("#datetimepicker6").trigger('dp.change');
            $("#datetimepicker7").trigger('dp.change');

        });

    </script>


    {{--  Scrum Sortable  --}}
    <script>
        $( function() {
            $( ".scrum--list" ).sortable({
                connectWith: ".scrum--list",

                stop: function(event, ui) {
                    var list = [];

                    var $ul = ui.item.parents('ul');
                    var listtype = $ul.data('scrum-status');

                    $ul.children().each(function() {
                        list.push($(this).data('taskid'));
                    });

                    console.log(list);

                    $.ajax({
                        method: "post",
                        url: "/scrum/sortlist",
                        data: {
                            'scrumStatus': listtype,
                            'list': list
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                    })
                    .done(function( msg ) {
                        console.log( msg );
                    });

                    {{--  console.log(ui.item);  --}}
                    {{--  console.log(ui.sender);  --}}
                }

            }).disableSelection();
        } );
    </script>
</body>
</html>
