<x-mail::message>
# Ciao {{$user->name}}

Il tuo progetto '{{$project->title}}' è stato modificato correttamente

<x-mail::button :url="$proj_url">
Vedi dettaglio progetto
</x-mail::button>
 
Grazie,  <br>
il team di {{ config('app.name') }}
</x-mail::message>