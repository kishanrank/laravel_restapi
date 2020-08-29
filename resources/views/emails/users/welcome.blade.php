Hello {{ $user->name}},
Thank you for chooosing our platform, please verify your account by below link: 
{{route('users.verify', $user->verification_token)}}