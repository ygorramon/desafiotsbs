<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use App\Models\Challenge;
use App\Models\Doubt;
use Illuminate\Support\Facades\Auth;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            // Add some items to the menu...
            $event->menu->addIn('desafios', [
                'key' =>'desafios-disponiveis',
                'text' => 'Disponíveis',
                'url' => '/admin/desafios/disponiveis',
               
            ]);
          /*  $event->menu->addIn('desafios', [
                'key' =>'desafios-novos-disponiveis',
                'text' => 'Novos Disponíveis',
                'url' => '/admin/desafios/novo_disponiveis',
                'label' => Challenge::where('status','ENVIADO')->where('tipo', '=', '1')->count(),
            ]);
            */
            $event->menu->addIn('desafios', [
                'key' =>'meus-desafios',
                'text'    => 'Meus Desafios',
                'url'     => '/admin/desafios/meus',
              
        
            ]);
            $event->menu->addIn('desafios', [
                'key' =>'desafios-finalizados',
                'text' => 'Finalizados',
                'url'  => '#',
               

            ]);

            $event->menu->addIn('duvidas', [
                'key' => 'duvidas-atrasadas',
                'text'    => 'Dúvidas Atrasadas',
                'url'     => '/admin/duvidas/atrasadas',
                'label' => Doubt::where('status','ENVIADO')->count(),

            ]);
            $event->menu->addIn('duvidas', [
                'key' => 'duvidas-todas',
                'text' => 'Todas Dúvidas',
                'url'  => '/admin/duvidas',
                'label' => Doubt::all()->count(),
            ]);

            $event->menu->addIn('chats', [
                'key' =>'chats-abertos',
                'text' => 'Em aberto',
                'url'  => '/admin/desafios/meus/chats/abertos',
                'label' =>  Auth::user()->chats()->where('chats.status','mae')->with('challenge')->where('challenges.status','RESPONDIDO')->count(),
               
            ]);

            $event->menu->addIn('chats', [
                'key' =>'chats-todos',
                'text' => 'Meus Chats',
                'url'  => '/admin/desafios/meus/chats/todos',
                'label' =>  Auth::user()->chats()->with('challenge')->count(),
               
            ]);


           
        });
    }
    
}
