@extends('layouts.admin.app')

@section('title','')

@push('css_or_js')
    <style>

        @media print {
            .non-printable {
                display: none;
            }

            .printable {
                display: block;
            }
        }

        .hr-style-2 {
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, 0), rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0));
        }

        .hr-style-1 {
            overflow: visible;
            padding: 0;
            border: none;
            border-top: medium double #000000;
            text-align: center;
        }
        #printableAreaContent * {
            font-weight: normal;
        }
    </style>

    <style type="text/css" media="print">
        @page {
            size: auto;   /* auto is the initial value */
            margin: 2px;
        }

    </style>
@endpush

@section('content')

    <div class="content container-fluid" style="color: black">
        <div class="row justify-content-center" id="printableArea">
            <div class="col-md-12">
                <center>
                    <input type="button" class="btn btn-primary non-printable" onclick="printDiv('printableArea')"
                           value="{{translate('Proceed, If thermal printer is ready.')}}"/>
                    <a href="{{url()->previous()}}" class="btn btn-danger non-printable">{{translate('Back')}}</a>
                </center>
                <hr class="non-printable">
            </div>
            <div class="invoice_print" id="printableAreaContent">
                <div class="text-center pt-4 mb-3">
                    <h2 style="line-height: 1">{{\App\Model\BusinessSetting::where(['key'=>'restaurant_name'])->first()->value}}</h2>
                    <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
                        {{\App\Model\BusinessSetting::where(['key'=>'address'])->first()->value}}
                    </h5>
                    <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                        Phone : {{\App\Model\BusinessSetting::where(['key'=>'phone'])->first()->value}}
                    </h5>
                    <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
                        GSTIN : {{\App\Model\BusinessSetting::where(['key'=>'gst_number'])->first()->value}}
                    </h5>
                   
                </div>
                <hr class="text-dark hr-style-1">

                <div class="row mt-4">
                    <div class="col-6 order_id">
                        <h5 class="order_id">{{translate('Order ID : ')}}{{$order['id']}}</h5>
                    </div>
                    <div class="col-6 date-order">
                        <h5 style="font-weight: lighter ">
                            <span class="font-weight-normal">{{date('d/M/Y h:m a',strtotime($order['created_at']))}}</span>
                        </h5>
                    </div>
                    <div class="col-12">
                        @if($order->is_guest == 0)
                            @if(isset($order->customer))
                                <h5>
                                    {{translate('Customer Name : ')}}<span class="font-weight-normal">{{$order->customer['f_name'].' '.$order->customer['l_name']}}</span>
                                </h5>
                                <h5>
                                    {{translate('Phone : ')}}<span class="font-weight-normal">{{$order->customer['phone']}}</span>
                                </h5>
                                @php($address=\App\Model\CustomerAddress::find($order['delivery_address_id']))
                                <h5>
                                    {{translate('Address : ')}}<span class="font-weight-normal">{{isset($address)?$address['address']:''}}</span>
                                </h5>
                            @endif
                        @endif
                        @if($order->is_guest == 1)
                            @if($order->order_type == 'delivery')
                                    @if(isset($order->delivery_address))
                                        <h5>
                                            {{translate('Customer Name : ')}}<span class="font-weight-normal">{{$order->delivery_address['contact_person_name']}}</span>
                                        </h5>
                                        <h5>
                                            {{translate('Phone : ')}}<span class="font-weight-normal">{{$order->delivery_address['contact_person_number']}}</span>
                                        </h5>
                                        <h5>
                                            {{translate('Address : ')}}<span class="font-weight-normal">{{$order->delivery_address['address']}}</span>
                                        </h5>
                                    @endif
                            @endif
                        @endif
                    </div>
                </div>
                <h5 class="text-uppercase"></h5>
                <hr class="text-dark hr-style-2">
                <table class="table table-bordered mt-3">
                    <thead>
                    <tr>
                        <th style="width: 10%;font-weight:600" >{{translate('QTY')}}</th>
                        <th style="font-weight:600">{{translate('DESCRIPTION')}}</th>
                        <th style="text-align:center;font-weight:600" >{{translate('PRICE')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($sub_total=0)
                    @php($total_tax=0)
                    @php($total_dis_on_pro=0)
                    @php($add_ons_cost=0)
                    @php($add_on_tax=0)
                    @php($add_ons_tax_cost=0)
                    @foreach($order->details as $detail)
                        @if($detail->product)
                            @php($add_on_qtys=json_decode($detail['add_on_qtys'],true))
                            @php($add_on_prices=json_decode($detail['add_on_prices'],true))
                            @php($add_on_taxes=json_decode($detail['add_on_taxes'],true))

                            <tr>
                                <td class="">
                                    {{$detail['quantity']}}
                                </td>
                                <td class="" style="text-align:left;text-transform:capitalize">
                                    <span style="word-break: break-all; " class="font-weight-bold"> {{ Str::limit($detail->product['name'], 200) }}</span><br>
                                    @if (count(json_decode($detail['variation'], true)) > 0)
                                        <strong>{{ translate('variation') }} : </strong>
                                        @foreach(json_decode($detail['variation'],true) as  $variation)
                                            @if ( isset($variation['name'])  && isset($variation['values']))
                                                <span class="d-block text-capitalize ">
                                                    <strong>{{  $variation['name']}} : </strong>
                                                </span>
                                                @foreach ($variation['values'] as $value)
                                                    <span class="d-block text-capitalize">
                                                        {{ $value['label']}} :
                                                        <strong>{{\App\CentralLogics\Helpers::set_symbol( $value['optionPrice'])}}</strong>
                                                    </span>
                                                @endforeach
                                            @else
                                                @if (isset(json_decode($detail['variation'],true)[0]))
                                                    @foreach(json_decode($detail['variation'],true)[0] as $key1 =>$variation)
                                                        <div class="font-size-sm ">
                                                            <span>{{$key1}} :  </span>
                                                            <span class="font-weight-bold">{{$variation}}</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                                @break
                                            @endif
                                        @endforeach
                                    @else
                                        <div class="font-size-sm ">
                                            <span>{{ translate('Price') }} : </span>
                                            <span
                                                class="">{{ \App\CentralLogics\Helpers::set_symbol($detail->price) }}</span>
                                        </div>
                                    @endif

                                    <div class="font-size-sm">
                                    @foreach(json_decode($detail['add_on_ids'],true) as $key2 =>$id)
                                        @php($addon=\App\Model\AddOn::find($id))
                                        @if($key2==0)<strong>{{translate('Addons : ')}}</strong>@endif

                                        @if($add_on_qtys==null)
                                            @php($add_on_qty=1)
                                        @else
                                            @php($add_on_qty=$add_on_qtys[$key2])
                                        </div>
                                        @endif

                                        <div class="font-size-sm text-body">
                                            <span>{{$addon ? $addon['name'] : translate('addon deleted')}} :  </span>
                                            <span class="font-weight-bold">
                                                {{$add_on_qty}} x {{ \App\CentralLogics\Helpers::set_symbol($add_on_prices[$key2]) }}
                                            </span>
                                        </div>
                                        @php($add_ons_cost+=$add_on_prices[$key2] * $add_on_qty)
                                        @php($add_ons_tax_cost +=  $add_on_taxes[$key2] * $add_on_qty)
                                    @endforeach

                                    {{translate('Discount : ')}}{{ \App\CentralLogics\Helpers::set_symbol($detail['discount_on_product']) }}
                                </td>
                                <td style="width: 28%;padding-right:4px; text-align:right">
                                    @php($amount=($detail['price']-$detail['discount_on_product'])*$detail['quantity'])
                                    {{ \App\CentralLogics\Helpers::set_symbol($amount) }}
                                </td>
                            </tr>
                            @php($sub_total+=$amount)
                            @php($total_tax+=($detail['tax_amount']*$detail['quantity']) )
                        @endif
                    @endforeach
                    </tbody>
                </table>


                <div class="row justify-content-md-end mb-3 m-0" style="width: 99%">
                    <div class="col-md-10 p-0">
                        <dl class="row text-right" style="color: black!important;">
                            <dt class="col-6">{{translate('Items Price:')}}</dt>
                            <dd class="col-6">{{ \App\CentralLogics\Helpers::set_symbol($sub_total) }}</dd>
                           
                            <dt class="col-6">{{translate('Addon Cost:')}}</dt>
                            <dd class="col-6">
                                {{ \App\CentralLogics\Helpers::set_symbol($add_ons_cost) }}
                                <hr>
                            </dd>

                            <dt class="col-6">{{translate('Subtotal:')}}</dt>
                            <dd class="col-6">
                                {{ \App\CentralLogics\Helpers::set_symbol($sub_total+$total_tax+$add_ons_cost+$add_ons_tax_cost) }}</dd>
                            <dt class="col-6">{{translate('Extra Discount')}}:</dt>
                            <dd class="col-6">
                                - {{ \App\CentralLogics\Helpers::set_symbol($order['extra_discount']) }}</dd>
                            <dt class="col-6">{{translate('Coupon Discount:')}}</dt>
                            
                            <dd class="col-6">
                                - {{ \App\CentralLogics\Helpers::set_symbol($order['coupon_discount_amount']) }}</dd>
                                <dt class="col-6">{{translate('Tax / GST:')}}</dt>
                                <dd class="col-6">{{ \App\CentralLogics\Helpers::set_symbol($total_tax + $add_ons_tax_cost) }}</dd>
                                
                            <dt class="col-6">{{translate('Delivery Fee:')}}</dt>
                            <dd class="col-6">
                                @if($order['order_type']=='take_away')
                                    @php($del_c=0)
                                @else
                                    @php($del_c=$order['delivery_charge'])
                                @endif
                                {{ \App\CentralLogics\Helpers::set_symbol($del_c) }}
                                @if($order['packing_fee']==0.00)
                                <dt class="col-8">{{ translate('') }}</dt>
                                <dd class="col-4"></dd>
                               
                            @else
                          
                            <dt class="col-6">{{ translate('Packing Fee') }}:</dt>
                            <dd class="col-6">{{ \App\CentralLogics\Helpers::set_symbol($order['packing_fee']) }}</dd>
                            @endif
                                <hr>
                            </dd>
                      
                            <dt class="col-6" style="font-size: 20px">{{translate('Total:')}}</dt>
                            <dd class="col-6" style="font-size: 20px">{{ \App\CentralLogics\Helpers::set_symbol($sub_total+$del_c+$total_tax+$add_ons_cost-$order['coupon_discount_amount']-$order['extra_discount']+$add_ons_tax_cost+$order['packing_fee']) }}</dd>

                            <!-- partial payment-->
                            @if ($order->order_partial_payments->isNotEmpty())
                                @foreach($order->order_partial_payments as $partial)
                                    <dt class="col-6">
                                        <div class="">
                                            <span>
                                                {{translate('Paid By')}} ({{str_replace('_', ' ',$partial->paid_with)}})</span>
                                            <span style="font-weight:600">:</span>
                                        </div>
                                    </dt>
                                    <dd class="col-6 text-dark text-right">
                                        {{ \App\CentralLogics\Helpers::set_symbol($partial->paid_amount) }}
                                    </dd>
                                @endforeach
                                    <?php
                                    $due_amount = 0;
                                    $due_amount = $order->order_partial_payments->first()?->due_amount;
                                    ?>
                                <dt class="col-6">
                                    <div class="">
                                            <span>
                                                {{translate('Due Amount')}}</span>
                                        <span>:</span>
                                    </div>
                                </dt>
                                <dd class="col-6 text-dark text-right">
                                    {{ \App\CentralLogics\Helpers::set_symbol($due_amount) }}
                                </dd>
                            @endif
                        </dl>
                    </div>
                </div>
                <hr class="text-dark hr-style-2">
                <h5 class="text-center pt-3">
                    {{translate('"""THANK YOU"""')}}
                </h5>
                <hr class="text-dark hr-style-2">
                <div class="text-center">{{\App\Model\BusinessSetting::where(['key'=>'footer_text'])->first()->value}}</div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        function printDiv(divName) {

            if($('html').attr('dir') === 'rtl') {
                $('html').attr('dir', 'ltr')
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                $('#printableAreaContent').attr('dir', 'rtl')
                window.print();
                document.body.innerHTML = originalContents;
                $('html').attr('dir', 'rtl')
            }else{
                var printContents = document.getElementById(divName).innerHTML;
                var originalContents = document.body.innerHTML;
                document.body.innerHTML = printContents;
                window.print();
                document.body.innerHTML = originalContents;
            }

        }
    </script>
@endpush
