import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_app/features/authentication/domain/usecases/login_staff.dart';
import 'package:tsth_app/features/authentication/domain/usecases/logout_staff.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_event.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_state.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
  final LoginStaff loginStaff;
  final LogoutStaff logoutStaff;

  AuthBloc({required this.loginStaff, required this.logoutStaff})
    : super(AuthInitial()) {
    on<LoginEvent>((event, emit) async {
      emit(AuthLoading());
      try {
        final user = await loginStaff(event.username, event.password);
        if (user.active == false) {
          emit(AuthError("your account has not been activated"));
          return;
        }
        emit(AuthSuccess(user));
      } catch (e) {
        if (event.username.toLowerCase() == 'admin') {
          emit(AuthError('Only staff can access this page'));
          return;
        }
        emit(AuthError(e.toString()));
        print("error : ${e.toString()}");
      }
    });

    on<LogoutEvent>((event, emit) async {
      emit(AuthLoading());
      try {
        await logoutStaff();
        emit(AuthLogoutSucess());
      } catch (e) {
        emit(AuthError(e.toString()));
      }
    });
  }
}
