import 'package:go_router/go_router.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/pages/login_page.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/pages/dashboard_page.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/page/habitus_page.dart';
import 'package:tsth_mobile_apps/features/product/presentation/page/home_page.dart';
import 'package:tsth_mobile_apps/features/splash_screen/splash_screen_page.dart';
import 'package:tsth_mobile_apps/router/initial_router.dart';
import 'package:tsth_mobile_apps/utils/authentication_utils.dart';

final GoRouter appRouter = GoRouter(
  initialLocation: InitialRouter.splashScreen,
  redirect: (context, state) async {
    final loggedIn = await AuthenticationUtils.isLoggedIn();

    if (state.fullPath == InitialRouter.splashScreen ||
        state.fullPath == InitialRouter.loginScreen) {
      return null;
    }

    return loggedIn ? null : InitialRouter.loginScreen;
  },
  routes: [
    GoRoute(
      path: InitialRouter.splashScreen,
      builder: (context, state) => const SplashScreenPage(),
    ),
    GoRoute(
      path: InitialRouter.loginScreen,
      builder: (context, state) => LoginPage(),
    ),
    GoRoute(
      path: InitialRouter.productScreen,
      builder: (context, state) => HomePage(),
    ),
    GoRoute(
      path: InitialRouter.dashboardScreen,
      builder: (context, state) => DashboardPage(),
    ),
    GoRoute(
      path: InitialRouter.habitusScreen,
      builder: (context, state) => HabitusPage(),
    ),
  ],
);
