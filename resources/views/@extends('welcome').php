@extends('layout')

@section('con')


<div id="content">
    <fieldset id="LeftPanel">
        <div id="div_A" class="window top">
        </div>

        <div id="div_left" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>
        <div id="div_B" class="window bottom">

        </div>
    </fieldset>
    <div id="div_vertical" class="handler_vertical width-controller">
        <i class="fas fa-grip-lines-vertical text-white"></i>
    </div>
    <fieldset id="RightPanel">
        <div id="div_C" class="window top">

        </div>
        <div id="div_right" class="handler_horizontal text-center font-size-h3 text-white  mb-4">
            <i class="fas fa-grip-lines"></i>
        </div>

        <div id="div_D" class="window bottom">

        </div>
    </fieldset>
</div>


@endsection
