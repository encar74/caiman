<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team Settings') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @php
                     //@livewire('teams.update-team-name-form', ['team' => $team])
                     @endphp

            @livewire('teams.team-member-manager', ['team' => $team])

            @if (Gate::check('delete', $team) && ! $team->personal_team)
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @php
                     //@livewire('teams.delete-team-form', ['team' => $team])
                    @endphp
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
