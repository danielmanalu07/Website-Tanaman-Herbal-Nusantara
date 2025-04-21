import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/utils/auth_utils.dart';
import 'package:tsth_app/features/authentication/presentation/screen/home_screen.dart';
import 'package:tsth_app/features/authentication/presentation/screen/login_screen.dart';
import 'package:tsth_app/features/scanner/presentation/screen/qr_scan_screen.dart';
import 'package:tsth_app/features/splash_screen/splash_screen.dart';
import 'package:tsth_app/features/validation/presentation/screen/detail_validation_screen.dart';
import 'package:tsth_app/features/validation/presentation/screen/list_validation_screen.dart';
import 'package:tsth_app/features/validation/presentation/screen/validation_plant_screen.dart';
import 'package:tsth_app/routes/initial_route.dart';

final GoRouter appRouter = GoRouter(
  initialLocation: InitialRoute.splashScreen,
  redirect: (context, state) async {
    final isAuth = await AuthUtils.isLoggedIn();
    final loggingIn = state.fullPath == InitialRoute.loginScreen;

    if (!isAuth && !loggingIn) {
      // Kalau belum login dan bukan di halaman login, arahkan ke login
      return InitialRoute.loginScreen;
    }

    if (isAuth && loggingIn) {
      // Kalau sudah login tapi buka halaman login, arahkan ke home
      return InitialRoute.homeScreen;
    }

    return null; // Tidak ada redirect
  },
  routes: [
    GoRoute(
      path: InitialRoute.splashScreen,
      builder: (context, state) => const SplashScreen(),
    ),
    GoRoute(
      path: InitialRoute.loginScreen,
      builder: (context, state) => const LoginScreen(),
    ),
    GoRoute(
      path: InitialRoute.homeScreen,
      builder: (context, state) => const HomeScreen(),
    ),
    GoRoute(
      path: InitialRoute.scanQrScreen,
      builder: (context, state) => const QrScanScreen(),
    ),
    GoRoute(
      path: InitialRoute.validationScreen,
      builder: (context, state) => const ValidationPlantScreen(),
    ),
    GoRoute(
      path: InitialRoute.listValidationScreen,
      builder: (context, state) => const ListValidationScreen(),
    ),
    GoRoute(
      path: InitialRoute.detailValidationScreen,
      builder: (context, state) {
        final id = int.parse(state.pathParameters['id']!);
        return DetailValidationScreen(validationId: id);
      },
    ),
  ],
);
