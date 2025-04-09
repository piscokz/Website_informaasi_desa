<?php

use Livewire\Volt\Volt;

Volt::route('/items', 'items.index')
->middleware(['auth', 'verified'])
->name('itemss');
