import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_mobile_apps/features/dashboard/data/datasources/user_remote_data_source.dart';
import 'package:tsth_mobile_apps/features/dashboard/data/repositories/user_repository_impl.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/usecases/get_profile_usecase.dart';
import 'package:tsth_mobile_apps/features/dashboard/domain/usecases/logout_usecase.dart';
import 'package:tsth_mobile_apps/features/dashboard/presentation/bloc/dashboard_bloc.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/data/datasources/habitus_remote_data_source.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/data/repositories/habitus_repository_impl.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/domain/usecases/get_all_habitus_usecase.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_bloc.dart';
import 'package:tsth_mobile_apps/features/plant_habitus/presentation/bloc/habitus_event.dart';
import 'package:tsth_mobile_apps/router/appRouter.dart';
import 'package:tsth_mobile_apps/features/auth/data/datasources/auth_remote_data_source.dart';
import 'package:tsth_mobile_apps/features/auth/data/repositories/auth_repository_impl.dart';
// import 'package:tsth_mobile_apps/features/auth/domain/repositories/auth_repository.dart';
import 'package:tsth_mobile_apps/features/auth/domain/usecases/login_usecase.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:tsth_mobile_apps/features/product/data/repositories/product_repository_impl.dart';
import 'package:tsth_mobile_apps/features/product/presentation/bloc/product_bloc.dart';
import 'package:tsth_mobile_apps/features/product/presentation/bloc/product_event.dart';
// import 'package:tsth_mobile_apps/features/product/presentation/page/home_page.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  SystemChrome.setEnabledSystemUIMode(SystemUiMode.manual,
      overlays: SystemUiOverlay.values);
  runApp(MyApp());
}

class MyApp extends StatelessWidget {
  MyApp({super.key});

  final productRepository = ProductRepositoryImpl();
  final authRepository = AuthRepositoryImpl(AuthRemoteDataSource());
  final userRepository = UserRepositoryImpl(UserRemoteDataSource());
  final habitusRepository = HabitusRepositoryImpl(HabitusRemoteDataSource());

  // This widget is the root of your application.
  @override
  Widget build(BuildContext context) {
    return MultiBlocProvider(
      providers: [
        BlocProvider(
          create: (_) => ProductBloc(productRepository)..add(LoadProducts()),
        ),
        BlocProvider(
          create: (_) => AuthBloc(loginUsecase: LoginUsecase(authRepository)),
        ),
        BlocProvider(
          create: (_) => DashboardBloc(
            getProfileUsecase: GetProfileUsecase(userRepository),
            logoutUsecase: LogoutUsecase(userRepository),
          ),
        ),
        BlocProvider(
          create: (_) => HabitusBloc(GetAllHabitusUsecase(habitusRepository))
            ..add(LoadHabitus()),
        ),
      ],
      child: MaterialApp.router(
        debugShowCheckedModeBanner: false,
        title: 'Flutter Demo',
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
          useMaterial3: true,
        ),
        routerConfig: appRouter,
      ),
    );
  }
}
