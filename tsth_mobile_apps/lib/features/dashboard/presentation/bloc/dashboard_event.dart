abstract class DashboardEvent {}

class UserEvent extends DashboardEvent {}

class RefreshDashboardEvent extends DashboardEvent {
  List<Object?> get props => [];
}

class LogoutEvent extends DashboardEvent {}
