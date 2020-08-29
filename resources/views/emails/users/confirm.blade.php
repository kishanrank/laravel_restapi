Hello {{ $user->name}},
You have changed your mail account recently please verify your email by below link: 
{{route('users.verify', $user->verification_token)}}