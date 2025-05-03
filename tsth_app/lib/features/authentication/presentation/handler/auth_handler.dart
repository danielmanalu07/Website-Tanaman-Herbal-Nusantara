import 'package:flutter/material.dart';
import 'package:flutter/widgets.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/core/widgets/custom_snackbar.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_bloc.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_event.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_state.dart';
import 'package:tsth_app/routes/initial_route.dart';

class AuthHandler {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  void login(BuildContext context) {
    context.read<AuthBloc>().add(
      LoginEvent(
        username: usernameController.text,
        password: passwordController.text,
      ),
    );
  }

  void dispose() {
    usernameController.dispose();
    passwordController.dispose();
  }

  void authState(BuildContext context, AuthState state) {
    if (state is AuthLoading) {
      Future.microtask(() {
        showDialog(
          context: context,
          barrierDismissible: false,
          builder:
              (_) => const AlertDialog(
                content: Row(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    CircularProgressIndicator(color: ColorConstant.greenColor),
                    SizedBox(width: 16),
                    Text("Logging in..."),
                  ],
                ),
              ),
        );
      });
    } else if (state is AuthSuccess) {
      context.pop();
      CustomSnackbar.alert(context, 'Login Successfully', false);
      Future.delayed(const Duration(milliseconds: 500), () {
        context.go(InitialRoute.homeScreen);
      });
    } else if (state is AuthError) {
      context.pop();
      CustomSnackbar.alert(context, state.message, true);
    }
  }
}
