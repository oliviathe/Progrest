<div class="scroll-container bg-background rounded-3xl p-5 shadow-sm relative w-full max-w-sm hover:shadow-md hover:-translate-y-0.5 transition-all">
    <div class="absolute left-5 top-6 bottom-6 w-1 rounded-full {{ $status === 'cancelled' ? 'bg-red-500' :  ($status === 'in_progress' ? 'bg-orange-500' : 'bg-yellow-500') }}"></div>

    <div class="absolute right-5 top-7">
        @if($status === 'cancelled')
            <x-lucide-circle-x class="w-5 h-5 text-red-accent stroke-[2px]" />
        @elseif ($status == 'in_progress')
            <x-lucide-circle-alert class="w-5 h-5 text-orange-accent stroke-[2px]" />
        @elseif ($status == 'pending')
            <x-lucide-hourglass class="w-4 h-4 text-yellow-accent stroke-[2px]" />
        @endif
    </div>

    <div class="pl-5 flex flex-col min-w-0">
        <div class="mb-2 pr-6">
            @if ($priority == 'high')
                <span class="font-montserrat font-medium text-white uppercase text-sm bg-red-accent px-3 py-[2.5px] rounded-lg text-[12px] tracking-wider leading-none">
                    {{ __('main.task.high') }}
                </span>
            @elseif ($status == 'medium')
                <span class="font-montserrat font-medium text-white uppercase text-sm bg-orange-accent px-3 py-[2.5px] rounded-lg text-[12px] tracking-wider leading-none">
                    {{ __('main.task.medium') }}
                </span>
            @else
                <span class="font-montserrat font-medium text-white uppercase text-sm bg-yellow-accent px-3 py-[2.5px] rounded-lg text-[12px] tracking-wider leading-none">
                    {{ __('main.task.low') }}
                </span>
            @endif
        </div>

        <div class="mb-2 pr-6">
            @if ($status == 'in_progress')
                <span class="font-montserrat font-medium text-orange-accent uppercase text-sm">
                    {{ __('main.task.in-progress') }}
                </span>
            @elseif ($status == 'cancelled')
                <span class="font-montserrat font-medium text-red-accent uppercase text-sm">
                    {{ __('main.task.cancelled') }}
                </span>
            @elseif ($status == 'pending')
                <span class="font-montserrat font-medium text-yellow-accent uppercase text-sm">
                    {{ __('main.task.pending') }}
                </span>
            @endif
        </div>

        <h2 class="text-text-primary text-lg font-semibold font-montserrat leading-snug mb-3 pr-2 truncate">
            {{ $title }}
        </h2>

        <div class="flex items-center justify-between mt-1">
            <div class="flex flex-row gap-1.5 items-center">
                <x-lucide-calendar class="w-3.5 h-3.5 text-text-secondary"/> 
                <p class="font-montserrat text-text-secondary text-sm">{{ __('main.task.due') }} {{ $dueDate->format('d M Y') }}</p>
            </div>
            <p class="font-montserrat text-xs font-bold whitespace-nowrap ml-2 {{ $daysLeft < 0 ? 'text-red-accent' : 'text-yellow-accent' }}">
                @if($daysLeft < 0)
                    {{ trans_choice('main.task.days-late', abs($daysLeft), ['count' => abs($daysLeft)]) }}
                @elseif($daysLeft == 0)
                    {{ __('main.task.due-today') }}
                @else
                    {{ trans_choice('main.task.days-left', $daysLeft, ['count' => $daysLeft]) }}
                @endif
            </p>
        </div>
    </div>
</div>