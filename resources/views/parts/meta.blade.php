<?php use \App\Http\Controllers\metaTagController; $metaInfo = metaTagController::metaBuilder(url()->current())?>
<title>{{$metaInfo['site']['storename']}}</title>
<meta name="theme-color" content="{{$metaInfo['color']['hBgColor']}}"/>
<link rel="icon" href="{{ url('/img/settings/'.$metaInfo['site']['favicon'].'/') }}" type="image/x-icon" />
@if (sizeof($metaInfo)>2)
{{--  --}}
<meta property="og:title" content="{{$metaInfo['site']['storename'].' | '.$metaInfo['product']['nombre']}}">
<meta property="og:site_name" content="{{$metaInfo['site']['storename']}}">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:description" content="{{$metaInfo['product']['short_des']}}">
<meta property="og:type" content="article">
<meta property="og:image" content="{{ url('/img/products/'.$metaInfo['product']['image'].'/') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:title" content="{{$metaInfo['site']['storename'].' | '.$metaInfo['product']['nombre']}}">
<meta property="og:description" content="{{$metaInfo['product']['short_des']}}">
<meta property="og:image" content="{{ url('/img/products/'.$metaInfo['product']['image'].'/') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url('/') }}">
<meta property="twitter:title" content="{{$metaInfo['site']['storename'].' | '.$metaInfo['product']['nombre']}}">
<meta property="twitter:description" content="{{$metaInfo['product']['short_des']}}">
<meta property="twitter:image" content="{{ url('/img/products/'.$metaInfo['product']['image'].'/') }}">


{{--  --}}
@else
<meta property="og:title" content="{{$metaInfo['site']['storename']}}">
<meta property="og:site_name" content="{{$metaInfo['site']['storename']}}">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:description" content="Mi pequeña tienda">
<meta property="og:type" content="article">
<meta property="og:image" content="{{ url('/img/settings/'.$metaInfo['site']['image'].'/') }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url('/') }}">
<meta property="og:title" content="{{$metaInfo['site']['storename']}}">
<meta property="og:description" content="Mi pequeña tienda">
<meta property="og:image:width" content="600" />
<meta property="og:image:height" content="600" />
<meta property="og:image" content="{{ url('/img/settings/'.$metaInfo['site']['image'].'/') }}">

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url('/') }}">
<meta property="twitter:title" content="{{$metaInfo['site']['storename']}}">
<meta property="twitter:description" content="Mi pequeña tienda">
<meta property="twitter:image" content="{{ url('/img/settings/'.$metaInfo['site']['image'].'/') }}">

@endif
