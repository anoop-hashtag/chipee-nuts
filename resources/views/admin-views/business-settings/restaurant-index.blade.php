@extends('layouts.admin.app')

@section('title', translate('Business Settings'))

@section('content')
    <div class="content container-fluid">
        <!-- Page Header -->
        <div class="d-flex flex-wrap gap-2 align-items-center mb-4">
            <h2 class="h1 mb-0 d-flex align-items-center gap-2">
                <img width="20" class="avatar-img" src="{{asset('public/assets/admin/img/icons/business_setup2.png')}}" alt="">
                <span class="page-header-title">
                    {{translate('business_setup')}}
                </span>
            </h2>
        </div>
        <!-- End Page Header -->

        <!-- Inine Page Menu -->
        @include('admin-views.business-settings.partials._business-setup-inline-menu')

        <div class="card my-3">
            <div class="card-body" >
                <div class="d-flex justify-content-between align-items-center border rounded mb-2 px-3 py-2">
                    @php($config=\App\CentralLogics\Helpers::get_business_settings('maintenance_mode'))
                    <h5 class="mb-0 c1">
                        {{translate('maintenance_mode')}}
                    </h5>

                    <label class="switcher ml-auto mb-0">
                        <input type="checkbox" class="switcher_input" onclick="maintenance_mode()"
                            {{isset($config) && $config?'checked':''}}>
                        <span class="switcher_control"></span>
                    </label>
                </div>
                <p class="fz-12 mb-0">*{{ translate('By turning on maintenance mode, all your app and customer side website will be off. Only admin panel and seller panel will be functional') }}</p>
            </div>
        </div>

        <form action="{{route('admin.business-settings.restaurant.update-setup')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-3">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="tio-user"></i>
                        {{translate('Company Information')}}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @php($restaurant_name=\App\CentralLogics\Helpers::get_business_settings('restaurant_name'))
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('Company Name')}}<span class="text-danger">*</span></label>
                                <input type="text" value="{{$restaurant_name}}"
                                       name="restaurant_name" class="form-control" required placeholder="{{translate('Ex: ABC Company')}}">
                            </div>
                        </div>

                        @php($phone=\App\CentralLogics\Helpers::get_business_settings('phone'))
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('phone')}}<span class="text-danger">*</span></label>
                                <input type="text" value="{{$phone}}"
                                       name="phone" class="form-control" required placeholder="{{translate('Ex: +9xxx-xxx-xxxx')}}">
                            </div>
                        </div>

                        @php($email=\App\CentralLogics\Helpers::get_business_settings('email_address'))
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('email')}}<span class="text-danger">*</span></label>
                                <input type="email" value="{{$email}}"
                                       name="email" class="form-control" required placeholder="{{translate('Ex: contact@company.com')}}">
                            </div>
                        </div>

                        @php($address=\App\CentralLogics\Helpers::get_business_settings('address'))
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('address')}}<span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" required placeholder="{{translate('Ex: ABC Company')}}" style="resize: none;">{{$address}}</textarea>
                            </div>
                        </div>
                        

                        <div class="col-md-4 col-sm-6">
                            @php($logo=\App\Model\BusinessSetting::where('key','logo')->first()->value)
                            <div class="form-group">
                                <label class="text-dark">{{translate('logo')}}</label><small style="color: red">*
                                    ( {{translate('ratio')}} 3:1 )</small>
                                <div class="custom-file">
                                    <input type="file" name="logo" id="customFileEg1" class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label"
                                           for="customFileEg1">{{translate('choose_File')}}</label>
                                </div>

                                <div class="text-center mt-3">
                                    <img style="height: 100px;border: 1px solid; border-radius: 10px;" id="viewer"
                                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                         src="{{asset('storage/app/public/restaurant/'.$logo)}}" alt="logo image"/>
                                </div>
                                
                            </div>
                            
                        </div>
                        <div class="col-md-4 col-sm-6">
                            @php($fav_icon=\App\Model\BusinessSetting::where('key','fav_icon')->first()->value)
                            <div class="form-group">
                                <label class="text-dark">{{translate('Fav Icon')}}</label><small style="color: red">*
                                    ( {{translate('ratio')}} 1:1 )</small>
                                <div class="custom-file">
                                    <input type="file" name="fav_icon" id="customFileEg2" class="custom-file-input"
                                           accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                    <label class="custom-file-label"
                                           for="customFileEg2">{{translate('choose_File')}}</label>
                                </div>

                                <div class="text-center mt-3">
                                    <img style="height: 100px;border: 1px solid; border-radius: 10px;" id="viewer_2"
                                         onerror="this.src='{{asset('public/assets/admin/img/160x160/img2.jpg')}}'"
                                         src="{{asset('storage/app/public/restaurant/'.$fav_icon)}}" alt="fav"/>
                                </div>
                            </div>
                        </div>
                        @php($gstin=\App\CentralLogics\Helpers::get_business_settings('gst_number'))
                        <div class="col-md-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('GSTIN')}}<span class="text-danger"></span></label>
                                <input type="text" value="{{$gstin}}"
                                name="gst_number" class="form-control"  placeholder="{{translate('GSTIN')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="tio-briefcase mr-1"></i>
                        {{translate('Business Information')}}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row align-items-end">
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="country">{{ translate('country') }}</label>
                                <select id="country" name="country" class="form-control js-select2-custom">
                                    @php($selectedCountryId = \App\Model\BusinessSetting::where('key', 'country')->first()->value)
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ $country->id == $selectedCountryId ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label" for="state">{{ translate('state') }}</label>
                                @php($selectedStateId = \App\Model\BusinessSetting::where('key', 'states')->first()->value)
                                <select id="states" name="states" class="form-control js-select2-custom">
                                    <option value="">{{ translate('Select State') }}</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}" {{ $state->id == $selectedStateId ? 'selected' : '' }}>
                                            {{ $state->name }} <!-- Assuming $state->name contains the name of the state -->
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                        
                        
                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                        <script>
                            $(document).ready(function () {
                                $('#country').change(function () {
                                    var countryId = $(this).val();
                                    if (countryId) {
                                        $.ajax({
                                            type: 'GET',
                                           
                                            url: '{{ route("get-states", ":country_id") }}'.replace(':country_id', countryId),
                                            success: function (states) {
                                                $('#states').empty();
                                                $.each(states, function (key, value) {
                                                    $('#states').append('<option value="' + value.id + '">' + value.name + '</option>');
                                                });
                                            }
                                        });
                                    } else {
                                        $('#states').empty();
                                    }
                                });
                            });
                        </script>
                        
                         <script>
                            $(document).ready(function () {
                                $('#country').change(function () {
                                    var countryId = $(this).val();
                                    if (countryId) {
                                        $.ajax({
                                            type: 'GET',
                                            url: '{{ route("get_time_zone", ":country_id") }}'.replace(':country_id', countryId),
                                            success: function (timeZones) {
                                                $('#time_zone').empty();
                                                $.each(timeZones, function (key, timeZone) {
                                                    $('#time_zone').append('<option value="' + timeZone.id + '">' + timeZone.time_zone_name + '</option>');
                                                });
                                            }
                                        });
                                    } else {
                                        $('#time_zone').empty();
                                    }
                                });
                            });
                        </script>
                        
                        
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                            @php($citydata=\App\Model\BusinessSetting::where('key','cities')->first()->value)
                        <label class="input-label" for="cities">{{ translate('city') }}</label>
                        <select id="cities" name="cities" class="form-control js-select2-custom">
                            @foreach(json_decode($cities) as $city)
                                <option value="{{ $city->id }}" {{ $city->id == $citydata ? 'selected' : '' }}>
                                    {{ $city->city }}
                                </option>
                            @endforeach
                        </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label">{{translate('time_zone')}}</label>
                                <select name="time_zone" id="time_zone" data-maximum-selection-length="3" class="form-control js-select2-custom">
                                    
                                    <option value='Pacific/Midway'>(UTC-11:00) Midway Island</option>
                                    <option value='Pacific/Samoa'>(UTC-11:00) Samoa</option>
                                    <option value='Pacific/Honolulu'>(UTC-10:00) Hawaii</option>
                                    <option value='US/Alaska'>(UTC-09:00) Alaska</option>
                                    <option value='America/Los_Angeles'>(UTC-08:00) Pacific Time (US &amp; Canada)</option>
                                    <option value='America/Tijuana'>(UTC-08:00) Tijuana</option>
                                    <option value='US/Arizona'>(UTC-07:00) Arizona</option>
                                    <option value='America/Chihuahua'>(UTC-07:00) Chihuahua</option>
                                    <option value='America/Chihuahua'>(UTC-07:00) La Paz</option>
                                    <option value='America/Mazatlan'>(UTC-07:00) Mazatlan</option>
                                    <option value='US/Mountain'>(UTC-07:00) Mountain Time (US &amp; Canada)</option>
                                    <option value='America/Managua'>(UTC-06:00) Central America</option>
                                    <option value='US/Central'>(UTC-06:00) Central Time (US &amp; Canada)</option>
                                    <option value='America/Mexico_City'>(UTC-06:00) Guadalajara</option>
                                    <option value='America/Mexico_City'>(UTC-06:00) Mexico City</option>
                                    <option value='America/Monterrey'>(UTC-06:00) Monterrey</option>
                                    <option value='Canada/Saskatchewan'>(UTC-06:00) Saskatchewan</option>
                                    <option value='America/Bogota'>(UTC-05:00) Bogota</option>
                                    <option value='US/Eastern'>(UTC-05:00) Eastern Time (US &amp; Canada)</option>
                                    <option value='US/East-Indiana'>(UTC-05:00) Indiana (East)</option>
                                    <option value='America/Lima'>(UTC-05:00) Lima</option>
                                    <option value='America/Bogota'>(UTC-05:00) Quito</option>
                                    <option value='Canada/Atlantic'>(UTC-04:00) Atlantic Time (Canada)</option>
                                    <option value='America/Caracas'>(UTC-04:30) Caracas</option>
                                    <option value='America/La_Paz'>(UTC-04:00) La Paz</option>
                                    <option value='America/Santiago'>(UTC-04:00) Santiago</option>
                                    <option value='Canada/Newfoundland'>(UTC-03:30) Newfoundland</option>
                                    <option value='America/Sao_Paulo'>(UTC-03:00) Brasilia</option>
                                    <option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Buenos Aires</option>
                                    <option value='America/Argentina/Buenos_Aires'>(UTC-03:00) Georgetown</option>
                                    <option value='America/Godthab'>(UTC-03:00) Greenland</option>
                                    <option value='America/Noronha'>(UTC-02:00) Mid-Atlantic</option>
                                    <option value='Atlantic/Azores'>(UTC-01:00) Azores</option>
                                    <option value='Atlantic/Cape_Verde'>(UTC-01:00) Cape Verde Is.</option>
                                    <option value='Africa/Casablanca'>(UTC+00:00) Casablanca</option>
                                    <option value='Europe/London'>(UTC+00:00) Edinburgh</option>
                                    <option value='Etc/Greenwich'>(UTC+00:00) Greenwich Mean Time : Dublin</option>
                                    <option value='Europe/Lisbon'>(UTC+00:00) Lisbon</option>
                                    <option value='Europe/London'>(UTC+00:00) London</option>
                                    <option value='Africa/Monrovia'>(UTC+00:00) Monrovia</option>
                                    <option value='UTC'>(UTC+00:00) UTC</option>
                                    <option value='Europe/Amsterdam'>(UTC+01:00) Amsterdam</option>
                                    <option value='Europe/Belgrade'>(UTC+01:00) Belgrade</option>
                                    <option value='Europe/Berlin'>(UTC+01:00) Berlin</option>
                                    <option value='Europe/Berlin'>(UTC+01:00) Bern</option>
                                    <option value='Europe/Bratislava'>(UTC+01:00) Bratislava</option>
                                    <option value='Europe/Brussels'>(UTC+01:00) Brussels</option>
                                    <option value='Europe/Budapest'>(UTC+01:00) Budapest</option>
                                    <option value='Europe/Copenhagen'>(UTC+01:00) Copenhagen</option>
                                    <option value='Europe/Ljubljana'>(UTC+01:00) Ljubljana</option>
                                    <option value='Europe/Madrid'>(UTC+01:00) Madrid</option>
                                    <option value='Europe/Paris'>(UTC+01:00) Paris</option>
                                    <option value='Europe/Prague'>(UTC+01:00) Prague</option>
                                    <option value='Europe/Rome'>(UTC+01:00) Rome</option>
                                    <option value='Europe/Sarajevo'>(UTC+01:00) Sarajevo</option>
                                    <option value='Europe/Skopje'>(UTC+01:00) Skopje</option>
                                    <option value='Europe/Stockholm'>(UTC+01:00) Stockholm</option>
                                    <option value='Europe/Vienna'>(UTC+01:00) Vienna</option>
                                    <option value='Europe/Warsaw'>(UTC+01:00) Warsaw</option>
                                    <option value='Africa/Lagos'>(UTC+01:00) West Central Africa</option>
                                    <option value='Europe/Zagreb'>(UTC+01:00) Zagreb</option>
                                    <option value='Europe/Athens'>(UTC+02:00) Athens</option>
                                    <option value='Europe/Bucharest'>(UTC+02:00) Bucharest</option>
                                    <option value='Africa/Cairo'>(UTC+02:00) Cairo</option>
                                    <option value='Africa/Harare'>(UTC+02:00) Harare</option>
                                    <option value='Europe/Helsinki'>(UTC+02:00) Helsinki</option>
                                    <option value='Europe/Istanbul'>(UTC+02:00) Istanbul</option>
                                    <option value='Asia/Jerusalem'>(UTC+02:00) Jerusalem</option>
                                    <option value='Europe/Helsinki'>(UTC+02:00) Kyiv</option>
                                    <option value='Africa/Johannesburg'>(UTC+02:00) Pretoria</option>
                                    <option value='Europe/Riga'>(UTC+02:00) Riga</option>
                                    <option value='Europe/Sofia'>(UTC+02:00) Sofia</option>
                                    <option value='Europe/Tallinn'>(UTC+02:00) Tallinn</option>
                                    <option value='Europe/Vilnius'>(UTC+02:00) Vilnius</option>
                                    <option value='Asia/Baghdad'>(UTC+03:00) Baghdad</option>
                                    <option value='Asia/Kuwait'>(UTC+03:00) Kuwait</option>
                                    <option value='Europe/Minsk'>(UTC+03:00) Minsk</option>
                                    <option value='Africa/Nairobi'>(UTC+03:00) Nairobi</option>
                                    <option value='Asia/Riyadh'>(UTC+03:00) Riyadh</option>
                                    <option value='Europe/Volgograd'>(UTC+03:00) Volgograd</option>
                                    <option value='Asia/Tehran'>(UTC+03:30) Tehran</option>
                                    <option value='Asia/Muscat'>(UTC+04:00) Abu Dhabi</option>
                                    <option value='Asia/Baku'>(UTC+04:00) Baku</option>
                                    <option value='Europe/Moscow'>(UTC+04:00) Moscow</option>
                                    <option value='Asia/Muscat'>(UTC+04:00) Muscat</option>
                                    <option value='Europe/Moscow'>(UTC+04:00) St. Petersburg</option>
                                    <option value='Asia/Tbilisi'>(UTC+04:00) Tbilisi</option>
                                    <option value='Asia/Yerevan'>(UTC+04:00) Yerevan</option>
                                    <option value='Asia/Kabul'>(UTC+04:30) Kabul</option>
                                    <option value='Asia/Karachi'>(UTC+05:00) Islamabad</option>
                                    <option value='Asia/Karachi'>(UTC+05:00) Karachi</option>
                                    <option value='Asia/Tashkent'>(UTC+05:00) Tashkent</option>
                                    <option value='Asia/Calcutta'>(UTC+05:30) Chennai</option>
                                    <option value='Asia/Kolkata'>(UTC+05:30) Kolkata</option>
                                    <option value='Asia/Calcutta'>(UTC+05:30) Mumbai</option>
                                    <option value='Asia/Calcutta'>(UTC+05:30) New Delhi</option>
                                    <option value='Asia/Calcutta'>(UTC+05:30) Sri Jayawardenepura</option>
                                    <option value='Asia/Katmandu'>(UTC+05:45) Kathmandu</option>
                                    <option value='Asia/Almaty'>(UTC+06:00) Almaty</option>
                                    <option value='Asia/Dhaka'>(UTC+06:00) Dhaka</option>
                                    <option value='Asia/Yekaterinburg'>(UTC+06:00) Ekaterinburg</option>
                                    <option value='Asia/Rangoon'>(UTC+06:30) Rangoon</option>
                                    <option value='Asia/Bangkok'>(UTC+07:00) Bangkok</option>
                                    <option value='Asia/Bangkok'>(UTC+07:00) Hanoi</option>
                                    <option value='Asia/Jakarta'>(UTC+07:00) Jakarta</option>
                                    <option value='Asia/Novosibirsk'>(UTC+07:00) Novosibirsk</option>
                                    <option value='Asia/Hong_Kong'>(UTC+08:00) Beijing</option>
                                    <option value='Asia/Chongqing'>(UTC+08:00) Chongqing</option>
                                    <option value='Asia/Hong_Kong'>(UTC+08:00) Hong Kong</option>
                                    <option value='Asia/Krasnoyarsk'>(UTC+08:00) Krasnoyarsk</option>
                                    <option value='Asia/Kuala_Lumpur'>(UTC+08:00) Kuala Lumpur</option>
                                    <option value='Australia/Perth'>(UTC+08:00) Perth</option>
                                    <option value='Asia/Singapore'>(UTC+08:00) Singapore</option>
                                    <option value='Asia/Taipei'>(UTC+08:00) Taipei</option>
                                    <option value='Asia/Ulan_Bator'>(UTC+08:00) Ulaan Bataar</option>
                                    <option value='Asia/Urumqi'>(UTC+08:00) Urumqi</option>
                                    <option value='Asia/Irkutsk'>(UTC+09:00) Irkutsk</option>
                                    <option value='Asia/Tokyo'>(UTC+09:00) Osaka</option>
                                    <option value='Asia/Tokyo'>(UTC+09:00) Sapporo</option>
                                    <option value='Asia/Seoul'>(UTC+09:00) Seoul</option>
                                    <option value='Asia/Tokyo'>(UTC+09:00) Tokyo</option>
                                    <option value='Australia/Adelaide'>(UTC+09:30) Adelaide</option>
                                    <option value='Australia/Darwin'>(UTC+09:30) Darwin</option>
                                    <option value='Australia/Brisbane'>(UTC+10:00) Brisbane</option>
                                    <option value='Australia/Canberra'>(UTC+10:00) Canberra</option>
                                    <option value='Pacific/Guam'>(UTC+10:00) Guam</option>
                                    <option value='Australia/Hobart'>(UTC+10:00) Hobart</option>
                                    <option value='Australia/Melbourne'>(UTC+10:00) Melbourne</option>
                                    <option value='Pacific/Port_Moresby'>(UTC+10:00) Port Moresby</option>
                                    <option value='Australia/Sydney'>(UTC+10:00) Sydney</option>
                                    <option value='Asia/Yakutsk'>(UTC+10:00) Yakutsk</option>
                                    <option value='Asia/Vladivostok'>(UTC+11:00) Vladivostok</option>
                                    <option value='Pacific/Auckland'>(UTC+12:00) Auckland</option>
                                    <option value='Pacific/Fiji'>(UTC+12:00) Fiji</option>
                                    <option value='Pacific/Kwajalein'>(UTC+12:00) International Date Line West</option>
                                    <option value='Asia/Kamchatka'>(UTC+12:00) Kamchatka</option>
                                    <option value='Asia/Magadan'>(UTC+12:00) Magadan</option>
                                    <option value='Pacific/Fiji'>(UTC+12:00) Marshall Is.</option>
                                    <option value='Asia/Magadan'>(UTC+12:00) New Caledonia</option>
                                    <option value='Asia/Magadan'>(UTC+12:00) Solomon Is.</option>
                                    <option value='Pacific/Auckland'>(UTC+12:00) Wellington</option>
                                    <option value='Pacific/Tongatapu'>(UTC+13:00) Nuku'alofa</option>
                                </select>
                            </div>
                            
                        </div>
                                                    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to update timezone options based on the selected country
        function updateTimeZoneOptions(countryCode) {
            // Clear existing options
            $('#time_zone').empty();
            console.log(countryCode);

            // Add options based on the selected country
            switch (countryCode) {
                case 'AF': // Afghanistan
                    $('#time_zone').append('<option value="Asia/Kabul">(UTC+04:30) Kabul</option>');
                    // Add more timezone options for Afghanistan
                    break;
                case 'AX': // Åland Islands
                    $('#time_zone').append('<option value="Europe/Mariehamn">(UTC+02:00) Mariehamn</option>');
                    // Add more timezone options for Åland Islands
                    break;
                case '101': // Åland Islands
                    $('#time_zone').append(' <option value="Asia/Kolkata">(UTC+05:30) Kolkata</option>');

                    // Add more timezone options for Åland Islands
                    break;
                case 'US': // United States
                $('#time_zone').append('<option value="America/New_York">(UTC-05:00) Eastern Time</option>');
                
                // Add more timezone options for United States
                   break;
                // Add cases for other countries
                // Ensure to include timezone options for all countries
                default:
                    // Default options when no country is selected
                    $('#time_zone').append('<option value="">Select a country first</option>');
            }
        }

        // Event listener for country select change event
        $('#country').change(function() {
            var selectedCountry = $(this).val();
            updateTimeZoneOptions(selectedCountry);
        });

        // Initialize timezone options based on the initially selected country (if any)
        updateTimeZoneOptions($('#country').val());
    });

                            </script>
                        @php($time_format=\App\CentralLogics\Helpers::get_business_settings('time_format') ?? '24')
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('time_format')}}</label>
                                <select name="time_format" class="form-control js-select2-custom">
                                    <option value="12" {{$time_format=='12'?'selected':''}}>{{translate('12_hour')}}</option>
                                    <option value="24" {{$time_format=='24'?'selected':''}}>{{translate('24_hour')}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            @php($date_format=\App\Model\BusinessSetting::where('key','date_format')->first()->value)
                           
                            <div class="form-group">
                                <label class="input-label">{{ translate('Date Format') }}</label>
                                <select name="date_format" class="form-control js-select2-custom">
                                    @foreach ($dateFormats as $dateFormated)
                                        <option value="{{ $dateFormated->date }}" {{ $date_format == $dateFormated->date ? 'selected' : '' }}>
                                            {{ $dateFormated->view_date }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    
                        
                        @php($currency_code=\App\Model\BusinessSetting::where('key','currency')->first()->value)
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label">{{translate('currency')}}</label>
                                <select name="currency" class="form-control js-select2-custom">
                                    @foreach(\App\Model\Currency::orderBy('currency_code')->get() as $currency)
                                        <option value="{{$currency['currency_code']}}" {{$currency_code==$currency['currency_code']?'selected':''}}>
                                            {{$currency['currency_code']}} ( {{$currency['currency_symbol']}} )
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label">{{translate('Currency_Position')}}</label>
                                <div class="">
                                    @php($config=\App\CentralLogics\Helpers::get_business_settings('currency_symbol_position'))
                                    <!-- Custom Radio -->
                                    <div class="form-control d-flex flex-column-2">
                                        <div class="custom-radio d-flex gap-2 align-items-center"
                                             onclick="currency_symbol_position('{{route('admin.business-settings.currency-position',['left'])}}')">
                                            <input type="radio" class=""
                                                   name="projectViewNewProjectTypeRadio"
                                                   id="projectViewNewProjectTypeRadio1" {{(isset($config) && $config=='left')?'checked':''}}>
                                            <label class="media align-items-center mb-0"
                                                   for="projectViewNewProjectTypeRadio1">
                                                    <span class="media-body">
                                                        ({{\App\CentralLogics\Helpers::currency_symbol()}}) {{translate('Left')}}
                                                    </span>
                                            </label>
                                        </div>

                                        <div class="custom-radio d-flex gap-2 align-items-center"
                                             onclick="currency_symbol_position('{{route('admin.business-settings.currency-position',['right'])}}')">
                                            <input type="radio" class=""
                                                   name="projectViewNewProjectTypeRadio"
                                                   id="projectViewNewProjectTypeRadio2" {{(isset($config) && $config=='right')?'checked':''}}>
                                            <label class="media align-items-center mb-0"
                                                   for="projectViewNewProjectTypeRadio2">
                                                    <span class="media-body">
                                                        Right ({{\App\CentralLogics\Helpers::currency_symbol()}})
                                                    </span>
                                            </label>
                                        </div>
                                    </div>
                                    <!-- End Custom Radio -->
                                </div>
                            </div>
                        </div>
                        @php($decimal_point_settings=\App\CentralLogics\Helpers::get_business_settings('decimal_point_settings'))
                        <div class="col-lg-4 col-sm-6">
                            <div class="form-group">
                                <label class="input-label text-capitalize">{{translate('digit_After_Decimal_Point ')}}({{translate(' ex: 0.00')}})<span style="color:red">*</span></label>
                                <input type="number" value="{{$decimal_point_settings}}"
                                       name="decimal_point_settings" class="form-control" placeholder="{{translate('Ex: 2')}}"
                                       required>
                            </div>
                        </div>
                        @php($footer_text=\App\Model\BusinessSetting::where('key','footer_text')->first()->value)
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="input-label">{{translate('Company_Copyright_Text')}}<span style="color:red">*</span></label>
                                <input type="text" value="{{$footer_text}}" name="footer_text" class="form-control"
                                       placeholder="{{translate('Ex: Copyright@efood.com')}}" required>
                            </div>
                        </div>
                        @php($pagination_limit=\App\Model\BusinessSetting::where('key','pagination_limit')->first()->value)
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="input-label">{{translate('pagination')}} <span style="color:red">*</span></label>
                                <input type="number" value="{{$pagination_limit}}" min="0"
                                       name="pagination_limit" class="form-control" placeholder="{{translate('Ex: 10')}}" required>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($sp=\App\CentralLogics\Helpers::get_business_settings('self_pickup'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('self_pickup')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('When this option is enabled the user may pick up their own order. ') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="self_pickup" {{$sp == null || $sp == 0? '' : 'checked'}} id="self_pickup_btn">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($del=\App\CentralLogics\Helpers::get_business_settings('delivery'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('delivery')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('If this option is turned off, the user will not receive home delivery.') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input readonly class="switcher_input" type="checkbox" name="delivery"  {{$del == null || $del == 0? '' : 'checked'}} id="delivery_btn">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($vnv_status=\App\CentralLogics\Helpers::get_business_settings('toggle_veg_non_veg'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('Pure_Veg / Non Veg / Egg Option')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('The system will not display the filter, on any categories based on Veg/ Non veg/ Egg, if this option is disabled.') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="toggle_veg_non_veg" {{$vnv_status == null || $vnv_status == 0? '' : 'checked'}} id="toggle_veg_non_veg">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($ev=\App\Model\BusinessSetting::where('key','email_verification')->first()->value)
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('email verification')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('If this field is active customers have to verify their email verification through an OTP.') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input name="email_verification" class="switcher_input" type="checkbox" {{$ev == 1? 'checked' : ''}} id="email_verification_on">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($pv=\App\CentralLogics\Helpers::get_business_settings('phone_verification'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('phone verification ( OTP )')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('If this field is active customers have to verify their phone number through an OTP.') }}">
                                        </i>
                                    </label>
                                </div>

                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="phone_verification" {{$pv == 1? 'checked' : ''}} id="phone_verification_on">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($dm_status=\App\CentralLogics\Helpers::get_business_settings('dm_self_registration'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('Delivery Partner Self Registration')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('When this field is active  delivery men can register themself using the delivery man app.') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="dm_self_registration" {{$dm_status == null || $dm_status == 0? '' : 'checked'}} id="dm_self_registration">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($guest_checkout=\App\CentralLogics\Helpers::get_business_settings('guest_checkout'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('Guest Checkout')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('When this option is active, users may place orders as guests without logging in.') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="guest_checkout" {{$guest_checkout == null || $guest_checkout == 0? '' : 'checked'}} id="guest_checkout">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6 mb-4">
                            @php($partial_payment=\App\CentralLogics\Helpers::get_business_settings('partial_payment'))
                            <div class="form-control d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <label class="text-dark mb-0">{{translate('Partial Payment')}}
                                        <i class="tio-info-outined"
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           title="{{ translate('When this option is enabled, users may pay up to a certain amount using their wallet balance.') }}">
                                        </i>
                                    </label>
                                </div>
                                <label class="switcher">
                                    <input class="switcher_input" type="checkbox" name="partial_payment" {{$partial_payment == null || $partial_payment == 0? '' : 'checked'}} id="partial_payment">
                                    <span class="switcher_control"></span>
                                </label>
                            </div>
                        </div>

                        <div class="col-lg-4 col-sm-6">
                            @php($combine_with=\App\CentralLogics\Helpers::get_business_settings('partial_payment_combine_with'))
                            <div class="form-group">
                                <label class="input-label">{{translate('Combine Payment With')}}
                                    <i class="tio-info-outined"
                                       data-toggle="tooltip"
                                       data-placement="top"
                                       title="{{ translate('The wallet balance will be combined with the chosen payment method to complete the transaction.') }}">
                                    </i>
                                </label>
                                <select name="partial_payment_combine_with" class="form-control">
                                    <option value="COD" {{(isset($combine_with) && $combine_with=='COD')?'selected':''}}>COD</option>
                                    <option value="digital_payment" {{(isset($combine_with) && $combine_with=='digital_payment')?'selected':''}}>Digital Payment</option>
                                    <option value="offline_payment" {{(isset($combine_with) && $combine_with=='offline_payment')?'selected':''}}>Offline Payment</option>
                                    <option value="all" {{(isset($combine_with) && $combine_with=='all')?'selected':''}}>All</option>
                                </select>
                            </div>

{{--                            <div class="mb-4">--}}
{{--                                <label class="input-label">{{translate('Combine Payment With')}}--}}
{{--                                    <i class="tio-info-outined"--}}
{{--                                       data-toggle="tooltip"--}}
{{--                                       data-placement="top"--}}
{{--                                       title="{{ translate('The wallet balance will be combined with the chosen payment method to complete the transaction.') }}">--}}
{{--                                    </i>--}}
{{--                                </label>--}}
{{--                                <div class="">--}}
{{--                                    <!-- Custom Radio -->--}}
{{--                                    <div class="form-control h-auto flex-wrap d-flex gap-3">--}}
{{--                                        <div class="custom-radio d-flex gap-2 align-items-center">--}}
{{--                                            <input type="radio" class=""--}}
{{--                                                   name="partial_payment_combine_with" value="COD"--}}
{{--                                                   id="partial_payment_combine_with_COD" {{(isset($combine_with) && $combine_with=='COD')?'checked':''}}>--}}
{{--                                            <label class="media align-items-center mb-0"--}}
{{--                                                   for="partial_payment_combine_with_COD">--}}
{{--                                                <span class="media-body">{{translate('COD')}}</span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}

{{--                                        <div class="custom-radio d-flex gap-2 align-items-center">--}}
{{--                                            <input type="radio" class=""--}}
{{--                                                   name="partial_payment_combine_with" value="digital_payment"--}}
{{--                                                   id="partial_payment_combine_with_digital_payment" {{(isset($combine_with) && $combine_with=='digital_payment')?'checked':''}}>--}}
{{--                                            <label class="media align-items-center mb-0"--}}
{{--                                                   for="partial_payment_combine_with_digital_payment">--}}
{{--                                                    <span class="media-body">--}}
{{--                                                        <span class="media-body">{{translate('Digital Payment')}}</span>--}}
{{--                                                    </span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-radio d-flex gap-2 align-items-center">--}}
{{--                                            <input type="radio" class=""--}}
{{--                                                   name="partial_payment_combine_with" value="offline_payment"--}}
{{--                                                   id="partial_payment_combine_with_offline" {{(isset($combine_with) && $combine_with=='offline_payment')?'checked':''}}>--}}
{{--                                            <label class="media align-items-center mb-0"--}}
{{--                                                   for="partial_payment_combine_with_offline">--}}
{{--                                                    <span class="media-body">--}}
{{--                                                        <span class="media-body">{{translate('Offline Payment')}}</span>--}}
{{--                                                    </span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        <div class="custom-radio d-flex gap-2 align-items-center">--}}
{{--                                            <input type="radio" class=""--}}
{{--                                                   name="partial_payment_combine_with" value="all"--}}
{{--                                                   id="partial_payment_combine_with_both" {{(isset($combine_with) && $combine_with=='all')?'checked':''}}>--}}
{{--                                            <label class="media align-items-center mb-0"--}}
{{--                                                   for="partial_payment_combine_with_both">--}}
{{--                                                    <span class="media-body">--}}
{{--                                                        <span class="media-body">{{translate('All')}}</span>--}}
{{--                                                    </span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- End Custom Radio -->--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn--container mt-4">
                <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}" onclick="{{env('APP_MODE')!='demo'?'':'call_demo()'}}" class="btn btn-primary">{{translate('submit')}}</button>
            </div>
        </form>
    </div>
@endsection

@push('script_2')
    <script>
        $(document).on('ready', function () {
            $('.js-select2-custom').each(function () {
                var select2 = $.HSCore.components.HSSelect2.init($(this));
            });
        });
    </script>
<!-- Your Blade Template -->


<script>
    $(document).ready(function() {
        $('#states').change(function() {
            var stateId = $(this).val();
            if (stateId) {
                $.ajax({
                    url: '{{ route("admin.business-settings.restaurant.getCities", ["stateId" => ":stateId"]) }}'.replace(':stateId', stateId),
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#cities').empty();
                        $.each(data, function(key, value) {
                            $('#cities').append('<option value="' + value.id + '">' + value.city + '</option>');
                        });
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log(xhr.responseText);
                    }
                });
            } else {
                $('#cities').empty();
            }
        });
    });
</script>


    <script>
        @php($time_zone=\App\Model\BusinessSetting::where('key','time_zone')->first())
        @php($time_zone = $time_zone->value ?? null)
        $('[name=time_zone]').val("{{$time_zone}}");

        @php($language=\App\Model\BusinessSetting::where('key','language')->first())
        @php($language = $language->value ?? null)
        let language = <?php echo($language); ?>;
        $('[id=language]').val(language);

        function readURL(input, viewer) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#' + viewer).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#customFileEg1").change(function() {
            readURL(this, 'viewer');
        });

        $("#customFileEg2").change(function() {
            readURL(this, 'viewer_2');
        });

        $("#language").on("change", function () {
            $("#alert_box").css("display", "block");
        });
    </script>

    <script>
        @if(env('APP_MODE')=='demo')
        function maintenance_mode() {
            toastr.info('{{translate('Disabled for demo version!')}}')
        }
        @else
        function maintenance_mode() {
            Swal.fire({
                // title: '{{translate('Are you sure?')}}',
                text: '{{translate('Be careful before you turn on/off maintenance mode')}}',
                type: 'warning',
                showCancelButton: true,
                cancelButtonColor: 'default',
                confirmButtonColor: '#377dff',
                cancelButtonText: '{{translate('No')}}',
                confirmButtonText:'{{translate('Yes')}}',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.get({
                        url: '{{route('admin.business-settings.maintenance-mode')}}',
                        contentType: false,
                        processData: false,
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function (data) {
                            toastr.success(data.message);
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                    });
                } else {
                    location.reload();
                }
            })
        };
        @endif

        function currency_symbol_position(route) {
            $.get({
                url: route,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    toastr.success(data.message);
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        }

        $(document).on('ready', function () {
            @php($country=\App\CentralLogics\Helpers::get_business_settings('country')??'BD')
            $("#country option[value='{{$country}}']").attr('selected', 'selected').change();
        })
    </script>

    <script>
        $(document).ready(function () {
            const message = "{{translate('Both Phone & Email verification can not be active at a time')}}";
            $("#phone_verification_on").click(function () {
                if ($('#phone_verification_on').prop("checked") === true) {
                    $('#email_verification_on').prop("checked") === true ? toastr.info(message) : '';
                    $('#email_verification_on').prop("checked", false);
                }
            });
            $("#email_verification_on").click(function () {
                if ($('#email_verification_on').prop("checked") === true) {
                    $('#phone_verification_on').prop("checked") === true ? toastr.info(message) : '';
                    $('#phone_verification_on').prop("checked", false);
                }
            });
        });
    </script>
@endpush
