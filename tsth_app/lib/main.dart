import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_app/features/authentication/data/dataSources/auth_remote_data_source.dart';
import 'package:tsth_app/features/authentication/data/repositories/auth_repository_impl.dart';
import 'package:tsth_app/features/authentication/domain/usecases/login_staff.dart';
import 'package:tsth_app/features/authentication/domain/usecases/logout_staff.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_bloc.dart';
import 'package:tsth_app/features/scanner/data/dataSource/plant_remote_data_source.dart';
import 'package:tsth_app/features/scanner/data/repositories/plant_repository_impl.dart';
import 'package:tsth_app/features/scanner/domain/usecases/GetPlantByIdUseCase.dart';
import 'package:tsth_app/features/scanner/presentation/bloc/plant_bloc.dart';
import 'package:tsth_app/features/validation/data/dataSource/validation_remote_dataSource.dart';
import 'package:tsth_app/features/validation/data/repositories/validation_repository_impl.dart';
import 'package:tsth_app/features/validation/domain/usecases/SaveValidationUseCase%20.dart';
import 'package:tsth_app/features/validation/domain/usecases/get_detail_validation.dart';
import 'package:tsth_app/features/validation/domain/usecases/get_validations.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_bloc.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/routes/app_route.dart';
import 'package:http/http.dart' as http;

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    final validationRepository = ValidationRepositoryImpl(
      validationRemoteDatasource: ValidationRemoteDatasource(http.Client()),
    );
    final getValidationUsecase = GetValidations(
      validationRepository: validationRepository,
    );
    final getDetailValidationUsecase = GetDetailValidation(
      validationRepository: validationRepository,
    );
    final saveValidationUseCase = Savevalidationusecase(validationRepository);
    final authRepository = AuthRepositoryImpl(AuthRemoteDataSource());
    final plantRepository = PlantRepositoryImpl(PlantRemoteDataSource());
    final getPlantByIdUseCase = Getplantbyidusecase(plantRepository);

    return MultiBlocProvider(
      providers: [
        BlocProvider(
          create:
              (_) => ValidationBloc(
                getValidationUsecase,
                getDetailValidationUsecase,
                saveValidationUseCase,
              )..add(LoadValidations()),
        ),
        BlocProvider(
          create:
              (_) => AuthBloc(
                loginStaff: LoginStaff(authRepository),
                logoutStaff: LogoutStaff(authRepository),
              ),
        ),
        BlocProvider(create: (_) => PlantBloc(getPlantByIdUseCase)),
      ],
      child: MaterialApp.router(
        debugShowCheckedModeBanner: false,
        theme: ThemeData(
          colorScheme: ColorScheme.fromSeed(seedColor: Colors.deepPurple),
          useMaterial3: true,
        ),
        routerConfig: appRouter,
      ),
    );
  }
}
