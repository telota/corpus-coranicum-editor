<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">Antiquity Market</div>
    </div>
    <div class="panel-body">

        {{--AUCTION HOUSES--}}

        <div class="panel-body">
            <div class="panel-title">Auction Houses</div>
            <hr>

            <div class="panel-body">
                <div class="space-between">
                    <?php
                    $i = 0;
                    $auctionHouses = \App\Models\Manuscripts\ManuscriptNew::getAuctionHouses();
                    $j = ceil(count($auctionHouses) / 4);
                    ?>
                    @foreach($auctionHouses as $auctionHouse => $label)
                        @if($i % $j == 0)
                            <div class="col-3">
                                @endif
                                <span class="input-group">
                        {!! Form::label("auction_house", $label) !!} &nbsp;
                        {!! Form::radio(
                            "auction_house",
                            $auctionHouse,
                            $record->antiquityMarket? $record->antiquityMarket->where("auction_house_id", $auctionHouse)->count() : 0
                        ) !!}
                    </span>
                                @if(($i + 1) % $j == 0 | $i == count($auctionHouses) - 1)
                            </div>
                        @endif
                        <?php   $i++;  ?>
                    @endforeach
                </div>
            </div>
            {{--            <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"--}}
            {{--                  rel="stylesheet">--}}
            {{--            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
            {{--            <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>--}}

            {{--DATE--}}

            <div class="panel-body">
                <div class="panel-title">Date</div>
                <hr>
                <div class="panel-body space-between">
      <span class="input-group">
            <input class="date form-control" name="antiquity_date" type="text"
                   value="{{$record->antiquityMarket ? $record->antiquityMarket->date : ""}}">
        </span>
                </div>

            </div>
            <script type="text/javascript">

                $('.date')
                    .datepicker({

                        format: 'yyyy-mm-dd'

                    });

            </script>

            {{--PRICE--}}

            <div class="panel-body">
                <div class="panel-title">Price</div>
                <hr>
                <div class="panel-body space-between">

                    <div class="input-group">

                        {!!Form::number("antiquity_price",
                            $record->antiquityMarket ? $record->antiquityMarket->price : 0,
                            ["class" => "form-control", "placeholder" => "Price in .." ])!!}
                    </div>
                    <div class="input-group">
                        {!! Form::select("antiquity_currency",
                            array_flip(\App\Models\Manuscripts\ManuscriptNew::getCurrencies()),
                            "Dollar") !!}
                    </div>
                </div>
            </div>
        </div>


    </div>

</div>


