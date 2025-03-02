import 'package:tsth_mobile_apps/features/dashboard/domain/entities/user.dart';

abstract class DashboardState {}

class DashboardInitial extends DashboardState {}

class DashboardLoading extends DashboardState {}

class DashboardLoaded extends DashboardState {
  final User user;

  DashboardLoaded(this.user);
}

class DashboardError extends DashboardState {
  final String message;

  DashboardError(this.message);
}

class LogoutSuccess extends DashboardState {}
