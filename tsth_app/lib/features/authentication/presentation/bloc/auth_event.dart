abstract class AuthEvent {}

class LoginEvent extends AuthEvent {
  final String username;
  final String password;

  LoginEvent({required this.username, required this.password});
}

class RefreshLoginEvent extends AuthEvent {}

class LogoutEvent extends AuthEvent {}
