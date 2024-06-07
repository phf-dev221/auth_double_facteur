<h5>Réinitialisation de mot e passe</h5>
   
<p>Vous pouvez confirmer vos identifiants en cliquant sur le lien ci-aprés en saisissant ce code:</p>
<p>{{$token}}</p>
<a href="{{ route('enter.otp.get', $token) }}">Valider</a>