<div>
    <x-slot name="title">
        My Team's
    </x-slot>
    <x-card>
        <div class="row">
            <div class="col-md-4">
                <x-input.text wire:model.blur="username" label="Search member's account" />
            </div>
            @if ($teamMember->placement_id)
                <div class="col-md-4">
                    <button class="mt-4 btn btn-primary mt-6" type="button"
                        wire:click="getTeam({id:'{{ $teamMember->placement_id }}'})">Up</button>
                </div>
            @endif

        </div>
    </x-card>
    <livewire:backend.components.member-view :no-footer="true" />
    {{-- <livewire:backend.component.member-tree-register /> --}}

    <x-card>
        <div class="my-tree">
            <ul class="row">
                <li class="col-12">
                    <x-team-toolkit :teamMember="$teamMember" class="col-6 offset-3 col-md-2 offset-md-5" />
                    <ul class="row">
                        <li class="col-6">
                            @if ($teamAMember)
                                <x-team-toolkit :teamMember="$teamAMember" class="col-8 offset-2 col-md-3 offset-md-4" />
                                {{-- @elseif($teamMember)
                                <x-team-register :placement_id="$teamMember->user_id" placement_team="1"
                                    class="col-8 offset-2 col-md-3 offset-md-4" /> --}}
                            @else
                                <x-team-available class="col-8 offset-2 col-md-3 offset-md-4" />
                            @endif
                            <ul class="row">
                                <li class="col-6">
                                    @if ($teamAMemberA)
                                        <x-team-toolkit :teamMember="$teamAMemberA" class="col-12 col-md-6 offset-md-3" />
                                        {{-- @elseif($teamAMember)
                                        <x-team-register :placement_id="$teamAMember->user_id" placement_team="1"
                                            class="col-12 col-md-6 offset-md-3" /> --}}
                                    @else
                                        <x-team-available class="col-12 col-md-6 offset-md-3" />
                                    @endif
                                </li>
                                <li class="col-6">
                                    @if ($teamAMemberB)
                                        <x-team-toolkit :teamMember="$teamAMemberB" class="col-12 col-md-6 offset-md-3" />
                                        {{-- @elseif($teamAMember)
                                        <x-team-register :placement_id="$teamAMember->user_id" placement_team="2"
                                            class="col-12 col-md-6 offset-md-3" /> --}}
                                    @else
                                        <x-team-available class="col-12 col-md-6 offset-md-3" />
                                    @endif
                                </li>
                            </ul>
                        </li>
                        <li class="col-6">
                            @if ($teamBMember)
                                <x-team-toolkit :teamMember="$teamBMember" class="col-8 offset-2 col-md-3 offset-md-4" />
                                {{-- @elseif($teamMember)
                                <x-team-register :placement_id="$teamMember->user_id" placement_team="2"
                                    class="col-8 offset-2 col-md-3 offset-md-4" /> --}}
                            @else
                                <x-team-available class="col-8 offset-2 col-md-3 offset-md-4" />
                            @endif
                            <ul class="row">
                                <li class="col-6">
                                    @if ($teamBMemberA)
                                        <x-team-toolkit :teamMember="$teamBMemberA" class="col-12 col-md-6 offset-md-3" />
                                        {{-- @elseif($teamBMember)
                                        <x-team-register :placement_id="$teamBMember->user_id" placement_team="1"
                                            class="col-12 col-md-6 offset-md-3" /> --}}
                                    @else
                                        <x-team-available class="col-12 col-md-6 offset-md-3" />
                                    @endif
                                </li>
                                <li class="col-6">
                                    @if ($teamBMemberB)
                                        <x-team-toolkit :teamMember="$teamBMemberB" class="col-12 col-md-6 offset-md-3" />
                                        {{-- @elseif($teamBMember)
                                        <x-team-register :placement_id="$teamBMember->user_id" placement_team="2"
                                            class="col-12 col-md-6 offset-md-3" /> --}}
                                    @else
                                        <x-team-available class="col-12 col-md-6 offset-md-3" />
                                    @endif
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </x-card>
</div>
@push('css')
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        .my-tree ul {
            padding-top: 20px;
            position: relative;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        .my-tree li {
            float: left;
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 20px 5px 0 5px;
            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*We will use ::before and ::after to draw the connectors*/

        .my-tree li::before,
        .my-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: 50%;
            border-top: 1px solid #ccc;
            width: 50%;
            height: 20px;
        }

        .my-tree li::after {
            right: auto;
            left: 50%;
            border-left: 1px solid #ccc;
        }

        /*We need to remove left-right connectors from elements without
                                                                                                                                                                                                                                                                                                                                                    any siblings*/

        .my-tree li:only-child::after,
        .my-tree li:only-child::before {
            display: none;
        }

        /*Remove space from the top of single children*/

        .my-tree li:only-child {
            padding-top: 0;
        }

        /*Remove left connector from first child and
                                                                                                                                                                                                                                                                                                                                                    right connector from last child*/

        .my-tree li:first-child::before,
        .my-tree li:last-child::after {
            border: 0 none;
        }

        /*Adding back the vertical connector to the last nodes*/

        .my-tree li:last-child::before {
            border-right: 1px solid #ccc;
            border-radius: 0 5px 0 0;
            -webkit-border-radius: 0 5px 0 0;
            -moz-border-radius: 0 5px 0 0;
        }

        .my-tree li:first-child::after {
            border-radius: 5px 0 0 0;
            -webkit-border-radius: 5px 0 0 0;
            -moz-border-radius: 5px 0 0 0;
        }

        /*Time to add downward connectors from parents*/

        .my-tree ul ul::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            border-left: 1px solid #ccc;
            width: 0;
            height: 20px;
        }

        .my-tree li div {
            /* border: 1px solid #ccc; */
            /* padding: 5px 10px; */
            /* text-decoration: none; */
            /* color: #666; */
            /* font-family: arial, verdana, tahoma; */
            /* font-size: 11px; */
            /* display: inline-block; */
            border-radius: 5px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;

            transition: all 0.5s;
            -webkit-transition: all 0.5s;
            -moz-transition: all 0.5s;
        }

        /*Time for some hover effects*/

        /*We will apply the hover effect the the lineage of the element also*/

        .my-tree li div:hover,
        .my-tree li div:hover+ul li div {
            /* background: #c8e4f8; */
            color: #000;
            border: 1px solid #94a0b4;
        }

        /*Connector styles on hover*/

        .my-tree li div:hover+ul li::after,
        .my-tree li div:hover+ul li::before,
        .my-tree li div:hover+ul::before,
        .my-tree li div:hover+ul ul::before {
            border-color: #94a0b4;
        }

        .btn-sm,
        .btn-group-sm>.btn {
            padding: 0.1rem 0.2rem;
        }

        .tooltiptext {
            visibility: visible;
            width: 200px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: auto;
            position: absolute;
            z-index: 1;
            -moz-border-radius: 5px;
            /* this works only in camino/firefox */
            -webkit-border-radius: 5px;
            /* this is just for Safari */
        }

        .tooltip_center {
            left: 50%;
            top: 30%;
        }

        .tooltip_right {
            right: 50%;
            top: 100%;
        }

        .tooltip_left {
            left: 50%;
            top: 100%;
        }
    </style>
@endpush
