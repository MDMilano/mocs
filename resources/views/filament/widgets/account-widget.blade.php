@php
    $user = filament()->auth()->user();
@endphp

<x-filament-widgets::widget class="fi-account-widget">
    <x-filament::section>
        <x-filament-panels::avatar.user
            size="lg"
            :user="$user"
            loading="lazy"
        />

        <div class="fi-account-widget-main">
            <h2 class="fi-account-widget-heading">
                Welcome, {{ filament()->getUserName($user) }}!
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                {{ $user->email }}
            </p>
        </div>

        <div class="flex items-center gap-2">
            
            <x-filament::button
                color="gray"
                icon="heroicon-o-computer-desktop"
                labeled-from="sm"
                tag="a"
                href="{{ route('knowledge-base') }}"
            >
                Switch to Knowledge Base
            </x-filament::button>

            <form
                action="{{ filament()->getLogoutUrl() }}"
                method="post"
                class="fi-account-widget-logout-form"
            >
                @csrf

                <x-filament::button
                    color="gray"
                    :icon="\Filament\Support\Icons\Heroicon::ArrowLeftEndOnRectangle"
                    :icon-alias="\Filament\View\PanelsIconAlias::WIDGETS_ACCOUNT_LOGOUT_BUTTON"
                    labeled-from="sm"
                    tag="button"
                    type="submit"
                >
                    {{ __('filament-panels::widgets/account-widget.actions.logout.label') }}
                </x-filament::button>
            </form>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
