
<style>
    .font-size-sm{
        font-size:12px;
    }
</style>    

<div style="width:320px;" id="printableAreaContent">
    <div class="text-center pt-4 mb-3 w-100">
        <h2 style="line-height: 1">{{\App\Model\BusinessSetting::where(['key'=>'restaurant_name'])->first()->value}}</h2>
        <h5 style="font-size: 20px;font-weight: lighter;line-height: 1">
            {{\App\Model\BusinessSetting::where(['key'=>'address'])->first()->value}}
        </h5>
        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
            {{translate('Phone')}}
            : {{\App\Model\BusinessSetting::where(['key'=>'phone'])->first()->value}}
        </h5>
        <h5 style="font-size: 16px;font-weight: lighter;line-height: 1">
            {{translate('GSTIN')}}
            : {{\App\Model\BusinessSetting::where(['key'=>'gst_number'])->first()->value}}
        </h5>
    </div>

    <span>--------------------------------------</span>
    <div class="row mt-3">
        <div class="col-6">
            <h5>{{translate('Order ID')}} : {{$order['id']}}</h5>
        </div>
        <div class="col-6">
            <h5 style="font-weight: lighter; " class="order_id font-size-sm">
                {{date('d/M/Y h:i a',strtotime($order['created_at']))}}
            </h5>
        </div>

        @if($order->customer)
            <div class="col-12">
                <h5>{{translate('Customer Name')}} : {{$order->customer['f_name'].' '.$order->customer['l_name']}}</h5>
                <h5>{{translate('Phone')}} : {{$order->customer['phone']}}</h5>
            </div>
        @else
            <div class="col-12">
                <h5>{{translate('Customer Name')}} : Walking Customer</h5>
                <h5>{{translate('Phone')}} : (XXX)-XXX-XXX </h5>
            </div>
        @endif

        @if(isset($order->customer['gst_number']) && !empty($order->customer['gst_number']))
    <div class="col-12">
        <h5>{{translate('GSTIN')}} : {{$order->customer['gst_number']}}</h5>
    </div>
@else
    <div class="col-12">
       
    </div>       
    @endif

    </div>
    <h5 class="text-uppercase"></h5>
    <span>--------------------------------------</span>
    <table class="table table-bordered mt-3" style="width: 98%">
        <thead>
        <tr>
            <th style="width: 10%">{{translate('QTY')}}</th>
            <th class="">{{translate('DESCRIPTION')}}</th>
            <th style="text-align:center;">{{translate('PRICE')}}</th>
        </tr>
        </thead>

        <tbody>
        @php($item_price=0)
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
                    <td class="" style="text-align:left">
                        <span style="word-break: break-all;"> {{ Str::limit($detail->product['name'], 200) }}</span><br>
                        @if (count(json_decode($detail['variation'], true)) > 0)
                            <strong>{{ translate('variation') }} : </strong>
                            @foreach(json_decode($detail['variation'],true) as  $variation)
                                @if ( isset($variation['name'])  && isset($variation['values']))
                                    <span class="d-block text-capitalize">
                                                        <strong>{{  $variation['name']}} - </strong>
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
                                            <div class="font-size-sm text-body">
                                                <span>{{$key1}} :  </span>
                                                <span class="font-weight-bold">{{$variation}}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                    @break
                                @endif
                            @endforeach
                        @else
                            <div class="font-size-sm text-body">
                                <span>{{ translate('Price') }} : </span>
                                <span
                                    class="font-weight-bold">{{ \App\CentralLogics\Helpers::set_symbol($detail->price) }}</span>
                            </div>
                        @endif

                        @foreach(json_decode($detail['add_on_ids'],true) as $key2 =>$id)
                            @php($addon=\App\Model\AddOn::find($id))
                            @if($key2==0)<strong class="font-size-sm">{{translate('Addons')}} :</strong>@endif

                            @if($add_on_qtys==null)
                                @php($add_on_qty=1)
                            @else
                                @php($add_on_qty=$add_on_qtys[$key2])
                            @endif

                            <div class="font-size-sm text-body" style="width:173px">
                                <span>{{$addon ? $addon['name'] : translate('addon deleted')}} :  </span>
                                <span class="font-weight-bold">
                                    {{$add_on_qty}} x {{ \App\CentralLogics\Helpers::set_symbol($add_on_prices[$key2]) }} <br>
                                </span>
                            </div>
                            <span class="font-size-sm">
                            @php($add_ons_cost+=$add_on_prices[$key2] * $add_on_qty)
                            @php($add_ons_tax_cost +=  $add_on_taxes[$key2] * $add_on_qty)
                        @endforeach
</span>
                        <span class="font-size-sm">
                        {{translate('Discount')}} : {{ \App\CentralLogics\Helpers::set_symbol($detail['discount_on_product']*$detail['quantity']) }}
                            </span>
                    </td>
                    <td style="padding-right:4px; text-align:right">
                        @php($amount=($detail['price']-$detail['discount_on_product'])*$detail['quantity'])
                        {{ \App\CentralLogics\Helpers::set_symbol($amount) }}
                    </td>
                </tr>
                @php($item_price+=$amount)
                @php($total_tax+=$detail['tax_amount']*$detail['quantity'])
            @endif
        @endforeach
        </tbody>
    </table>
    <span>--------------------------------------</span>
    <div class="row justify-content-md-end">
        <div class="col-md-9 col-lg-9">
            <dl class="row text-right" style="color: black!important;">
                <dt class="col-8">{{translate('Items Price')}}:</dt>
                <dd class="col-4">{{\App\CentralLogics\Helpers::set_symbol($item_price)}}</dd>
               
                <dt class="col-8">{{translate('Addon Cost')}}:</dt>
                <dd class="col-4">{{\App\CentralLogics\Helpers::set_symbol($add_ons_cost)}}
                    <hr>
                </dd>

                <dt class="col-8">{{translate('Subtotal')}}:</dt>
                @php($subtotal = $add_ons_cost + $item_price + $total_tax + $add_ons_tax_cost)
                <dd class="col-4">{{ \App\CentralLogics\Helpers::set_symbol($subtotal) }}</dd>
                <dt class="col-8">{{translate('Coupon Discount')}}:</dt>
                <dd class="col-4">
                    -{{ \App\CentralLogics\Helpers::set_symbol($order['coupon_discount_amount']) }}</dd>
                <dt class="col-8">{{translate('Extra Discount')}}:</dt>
                <dd class="col-4">-{{ \App\CentralLogics\Helpers::set_symbol($order['extra_discount']) }}</dd>
                    <dt class="col-8">{{translate('Tax')}} / {{translate('GST')}}:</dt>
                    <dd class="col-4">{{\App\CentralLogics\Helpers::set_symbol($total_tax + $add_ons_tax_cost)}}</dd>
                    @if($order['packing_fee']==0.00)
                    <dt class="col-8">{{ translate('') }}</dt>
                    <dd class="col-4"></dd>
                   
                @else
              
                <dt class="col-8">{{ translate('Packing Fee') }}:</dt>
                <dd class="col-4">{{ \App\CentralLogics\Helpers::set_symbol($order['packing_fee']) }}</dd>
                @endif
                
                

                    @if($order['order_type']=='delivery')
                    <dt class="col-8">{{translate('Delivery Fee:')}}</dt>
                
                <dd class="col-4">
                    @if($order['order_type']=='take_away')
                        @php($del_c=0)
                    @else
                        @php($del_c=$order['delivery_charge'])
                    @endif
                    {{ \App\CentralLogics\Helpers::set_symbol($del_c) }}
                    <hr>
                </dd>
                    @endif
                <dt class="col-8" style="display: none;">{{translate('Delivery Fee:')}}</dt>
                
                <dd class="col-4" style="display: none;">
                    @if($order['order_type']=='take_away')
                        @php($del_c=0)
                    @else
                        @php($del_c=$order['delivery_charge'])
                    @endif
                    {{ \App\CentralLogics\Helpers::set_symbol($del_c) }}
                    <hr>
                </dd>

                <dt class="col-6" style="font-size: 20px">{{translate('Total')}}:</dt>
                <dd class="col-6" style="font-size: 20px">{{ \App\CentralLogics\Helpers::set_symbol($subtotal-$order['coupon_discount_amount']-$order['extra_discount']+$del_c+$order['packing_fee']) }}</dd>
            </dl>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-between border-top">
        <span>{{translate('Paid_by')}}: <span style="font-weight:bold">{{ translate($order->payment_method)}}</span></span>
    </div>
    <span>--------------------------------------</span>
    <h5 class="text-center pt-3">
        """{{translate('THANK YOU')}}"""
    </h5>
    <span>--------------------------------------</span>
</div>
