import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_mobile_apps/features/auth/domain/usecases/login_usecase.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_event.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_state.dart';

class AuthBloc extends Bloc<AuthEvent, AuthState> {
  final LoginUsecase loginUsecase;

  AuthBloc({required this.loginUsecase}) : super(AuthInitial()) {
    on<LoginEvent>((event, emit) async {
      emit(AuthLoading());
      try {
        final user = await loginUsecase.execute(event.username, event.password);
        emit(AuthAuthenticated(user));
      } catch (e) {
        emit(AuthError(e.toString()));
      }
    });

    on<RefreshLoginEvent>((event, emit) async {
      emit(AuthLoading());
    });
  }
}
