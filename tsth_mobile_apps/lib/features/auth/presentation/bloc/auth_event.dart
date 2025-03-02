abstract class AuthEvent {}

class LoginEvent extends AuthEvent {
  final String username;
  final String password;

  LoginEvent(this.username, this.password);
}

class RefreshLoginEvent extends AuthEvent {
  List<Object?> get props => [];
}
