import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_mobile_apps/core/widgets/custom_snackbar.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_event.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_state.dart';
import 'package:tsth_mobile_apps/router/initial_router.dart';
import 'package:tsth_mobile_apps/core/constant/color_constant.dart';

class AuthController {
  final TextEditingController usernameController = TextEditingController();
  final TextEditingController passwordController = TextEditingController();

  void login(BuildContext context) {
    context.read<AuthBloc>().add(
          LoginEvent(
            usernameController.text,
            passwordController.text,
          ),
        );
  }

  void dispose() {
    usernameController.dispose();
    passwordController.dispose();
  }

  void showSnackBar(BuildContext context, String message, bool isError) {
    final snackBar = SnackBar(
      content: Text(
        message,
        style: const TextStyle(color: Colors.white, fontSize: 16),
      ),
      backgroundColor: isError ? ColorConstant.red : ColorConstant.success,
      duration: const Duration(seconds: 3),
      behavior: SnackBarBehavior.floating,
      showCloseIcon: true,
      margin: const EdgeInsets.symmetric(horizontal: 20, vertical: 10),
      padding: const EdgeInsets.symmetric(horizontal: 20.0, vertical: 15.0),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
    );

    ScaffoldMessenger.of(context)
      ..clearSnackBars()
      ..showSnackBar(snackBar);
  }

  void handleAuthState(BuildContext context, AuthState state) {
    if (state is AuthLoading) {
      showDialog(
        context: context,
        barrierDismissible: false,
        builder: (context) {
          return const AlertDialog(
            content: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                CircularProgressIndicator(),
                SizedBox(width: 16),
                Text("Logging in..."),
              ],
            ),
          );
        },
      );
    } else if (state is AuthAuthenticated) {
      Navigator.of(context).pop();
      CustomSnackbar.show(context, 'Login Successfully', false);
      context.go(InitialRouter.productScreen);
    } else if (state is AuthError) {
      Navigator.of(context).pop();
      CustomSnackbar.show(context, state.message, true);
    }
  }
}
