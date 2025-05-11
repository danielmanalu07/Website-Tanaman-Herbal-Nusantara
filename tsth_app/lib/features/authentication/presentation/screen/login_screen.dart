import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/core/constant/path_constant.dart';
import 'package:tsth_app/core/widgets/custom_button.dart';
import 'package:tsth_app/core/widgets/custom_form.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_bloc.dart';
import 'package:tsth_app/features/authentication/presentation/bloc/auth_state.dart';
import 'package:tsth_app/features/authentication/presentation/handler/auth_handler.dart';

class LoginScreen extends StatefulWidget {
  const LoginScreen({super.key});

  @override
  State<LoginScreen> createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  late AuthHandler _authHandler;

  Future<void> _refresh() async {
    _authHandler.usernameController.clear();
    _authHandler.passwordController.clear();

    await Future.delayed(const Duration(seconds: 1));
  }

  @override
  void initState() {
    super.initState();
    _authHandler = AuthHandler();
  }

  @override
  void dispose() {
    _authHandler.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: ColorConstant.backgroundColor,
      body: BlocListener<AuthBloc, AuthState>(
        listener: (context, state) {
          _authHandler.authState(context, state);
        },
        child: RefreshIndicator(
          onRefresh: _refresh,
          child: Padding(
            padding: const EdgeInsets.all(32.0),
            child: SingleChildScrollView(
              physics: AlwaysScrollableScrollPhysics(),
              child: Center(
                child: Column(
                  spacing: 10.0,
                  crossAxisAlignment: CrossAxisAlignment.center,
                  mainAxisAlignment: MainAxisAlignment.start,
                  children: [
                    Image.asset(
                      PathConstant.logo,
                      width: 300,
                      fit: BoxFit.contain,
                    ),
                    Text(
                      "Login",
                      style: TextStyle(
                        color: ColorConstant.greenColor,
                        fontSize: 50,
                        fontFamily: 'poppins',
                        fontWeight: FontWeight.bold,
                        letterSpacing: 6.0,
                      ),
                    ),
                    const SizedBox(height: 50),
                    CustomForm(
                      label: "Username",
                      controller: _authHandler.usernameController,
                      isPassword: false,
                      keyboardType: TextInputType.name,
                      radius: 10.0,
                    ),
                    const SizedBox(height: 20),
                    CustomForm(
                      label: "Password",
                      controller: _authHandler.passwordController,
                      isPassword: true,
                      keyboardType: TextInputType.visiblePassword,
                      radius: 10.0,
                    ),
                    const SizedBox(height: 60),
                    CustomButton(
                      text: "Login",
                      onPressed: () {
                        _authHandler.login(context);
                      },
                      textColor: ColorConstant.whiteColor,
                      bgColor: ColorConstant.greenColor,
                      fontSize: 24,
                      fontWeight: FontWeight.bold,
                    ),
                  ],
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}
