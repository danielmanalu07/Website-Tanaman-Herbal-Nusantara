import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/usecases/get_profile_usecase.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/usecases/logout_usecase.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/bloc/dashboard_event.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/bloc/dashboard_state.dart';

class DashboardBloc extends Bloc<DashboardEvent, DashboardState> {
  final GetProfileUsecase getProfileUsecase;
  final LogoutUsecase logoutUsecase;

  DashboardBloc({required this.getProfileUsecase, required this.logoutUsecase})
      : super(DashboardInitial()) {
    on<UserEvent>((event, emit) async {
      emit(DashboardLoading());
      try {
        final user = await getProfileUsecase.execute();
        emit(DashboardLoaded(user));
      } catch (e) {
        if (e.toString().contains('401')) {
          add(LogoutEvent());
        } else {
          emit(DashboardError(e.toString()));
        }
      }
    });

    on<RefreshDashboardEvent>((event, emit) async {
      emit(DashboardLoading());
      try {
        final user = await getProfileUsecase.execute();
        emit(DashboardLoaded(user));
      } catch (e) {
        emit(DashboardError(e.toString()));
      }
    });

    on<LogoutEvent>((event, emit) async {
      try {
        await logoutUsecase.execute();
        emit(LogoutSuccess());
      } catch (e) {
        emit(DashboardError("Logout failed, please try again. Error: $e"));
      }
    });
  }
}
