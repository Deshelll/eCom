<?php

namespace App\Livewire;

use App\Models\RentalCard;
use App\Models\RentalTime;
use Carbon\Carbon;
use Livewire\Component;

class RentalCheckoutForm extends Component
{
    public $rentalCardId;
    public $rentalCard;
    public $selectedTimes = [];
    public $rentalTimes = [];

    public function mount($rentalCardId): void
    {
        $this->rentalCardId = $rentalCardId;
        $this->rentalCard = RentalCard::with('rentalTimes')->find($rentalCardId);
        $this->rentalTimes = $this->rentalCard->rentalTimes;
    }

    public function toggleTimeSelection($timeId): void
    {
        if (in_array($timeId, $this->selectedTimes)) {
            $this->selectedTimes = array_filter($this->selectedTimes, fn($id) => $id !== $timeId);
        } else {
            $this->selectedTimes[] = $timeId;
        }
    }

    public function goToPayment()
    {
        if (empty($this->selectedTimes)) {
            session()->flash('error', 'Не выбрано ни одно время!');
            return;
        }

        [$groupedTimes, $allTimes] = $this->groupTimes($this->selectedTimes);

        session()->put('checkout', [
            'type' => 'rental',
            'cardId' => $this->rentalCardId,
            'email' => auth()->user()->email,
            'groupedTimes' => $groupedTimes,
            'allTimes' => $allTimes,
        ]);

        return redirect()->route('payment');
    }

    public function groupTimes($selectedTimes)
    {
        $times = RentalTime::whereIn('id', $selectedTimes)->orderBy('start_time')->get();

        $groupedTimes = [];
        $allTimes = [];
        $start = null;
        $end = null;

        foreach ($times as $time) {
            $currentStart = Carbon::parse($time->start_time);
            $currentEnd = $currentStart->copy()->addMinutes(45);

            $allTimes[] = [$currentStart->format('H:i'), $currentEnd->format('H:i')];

            if ($start === null) {
                $start = $currentStart;
                $end = $currentEnd;
            } elseif ($currentStart->equalTo($end)) {
                $end = $currentEnd;
            } else {
                $groupedTimes[] = [$start->format('H:i'), $end->format('H:i')];
                $start = $currentStart;
                $end = $currentEnd;
            }
        }

        if ($start !== null && $end !== null) {
            $groupedTimes[] = [$start->format('H:i'), $end->format('H:i')];
        }

        return [$groupedTimes, $allTimes];
    }

    public function render()
    {
        return view('livewire.rental-checkout-form', [
            'rentalCard' => $this->rentalCard,
            'rentalTimes' => $this->rentalTimes,
        ])->extends('layouts.main');
    }
}
