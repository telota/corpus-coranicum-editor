{{--            <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"--}}
{{--                  rel="stylesheet">--}}
{{--            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
{{--            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>--}}

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title">Date of Entry</div>
    </div>

    <div class="panel-body space-between">

        <span class="input-group">
            <input class="date form-control" name="date_of_entry" type="text" value="{{$intertext->date_of_entry ? $intertext->date_of_entry : ""}}">
        </span>


    </div>

</div>
<script type="text/javascript">

  $('.date')
    .datepicker({

      format: 'yyyy-mm-dd'

    });

</script>
