import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_mobile_apps/core/buttons/custom_button.dart';
import 'package:tsth_mobile_apps/core/constant/color_constant.dart';
import 'package:tsth_mobile_apps/core/widgets/custom_text_field.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_bloc.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/bloc/auth_state.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/controller/auth_controller.dart';
import 'package:tsth_mobile_apps/features/auth/presentation/widget/custom_text.dart';
import 'package:tsth_mobile_apps/router/initial_router.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  State<LoginPage> createState() => _LoginPageState();
}

class _LoginPageState extends State<LoginPage> with TickerProviderStateMixin {
  late AnimationController _controller;
  late List<Animation<Offset>> _slideAnimations;
  late Animation<double> _fadeAnimation;
  late Animation<double> _scaleAnimation;
  late AuthController _authController;

  Future<void> _handleRefresh() async {
    _authController.usernameController.clear();
    _authController.passwordController.clear();

    _controller.reset();
    await _controller.forward();

    await Future.delayed(const Duration(milliseconds: 500));
  }

  @override
  void initState() {
    super.initState();
    _authController = AuthController();

    _controller = AnimationController(
      vsync: this,
      duration: const Duration(seconds: 2),
    );

    _fadeAnimation = Tween<double>(begin: 0.0, end: 1.0).animate(
      CurvedAnimation(parent: _controller, curve: Curves.easeIn),
    );

    _scaleAnimation = Tween<double>(begin: 0.8, end: 1.0).animate(
      CurvedAnimation(parent: _controller, curve: Curves.elasticOut),
    );

    _slideAnimations = [
      Tween<Offset>(begin: const Offset(-1.5, 0), end: Offset.zero).animate(
        CurvedAnimation(parent: _controller, curve: Curves.easeOut),
      ),
      Tween<Offset>(begin: const Offset(1.5, 0), end: Offset.zero).animate(
        CurvedAnimation(parent: _controller, curve: Curves.easeOut),
      ),
      Tween<Offset>(begin: const Offset(-1.5, 0), end: Offset.zero).animate(
        CurvedAnimation(parent: _controller, curve: Curves.easeOut),
      ),
      Tween<Offset>(begin: const Offset(1.5, 0), end: Offset.zero).animate(
        CurvedAnimation(parent: _controller, curve: Curves.easeOut),
      ),
    ];

    _controller.forward();
  }

  @override
  void dispose() {
    _controller.dispose();
    _authController.dispose();
    super.dispose();
  }

  void _showSnackBar(BuildContext context, String message, bool isError) {
    final snackBar = SnackBar(
      content: Text(
        message,
        style: TextStyle(
          color: ColorConstant.white,
          fontSize: 16,
        ),
      ),
      backgroundColor: isError ? ColorConstant.red : ColorConstant.success,
      duration: Duration(seconds: 3),
      behavior: SnackBarBehavior.floating,
      showCloseIcon: true,
      margin: EdgeInsets.only(
        bottom: 10,
        right: 20,
        left: 20,
      ),
      padding: EdgeInsets.symmetric(horizontal: 20.0, vertical: 15.0),
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(10.0),
      ),
    );

    ScaffoldMessenger.of(context)
      ..clearSnackBars()
      ..showSnackBar(snackBar);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: ColorConstant.background,
      body: BlocListener<AuthBloc, AuthState>(
        listener: (context, state) {
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
            context.pop();
            _showSnackBar(context, 'Login Successfully', false);
            context.go(InitialRouter.dashboardScreen);
          } else if (state is AuthError) {
            context.pop();
            _showSnackBar(context, state.message, true);
          }
        },
        child: RefreshIndicator(
          onRefresh: _handleRefresh,
          color: ColorConstant.buttonColor,
          backgroundColor: ColorConstant.background,
          child: CustomScrollView(
            physics: AlwaysScrollableScrollPhysics(),
            slivers: [
              SliverFillRemaining(
                hasScrollBody: false,
                child: Padding(
                  padding: const EdgeInsets.symmetric(
                      vertical: 16.0, horizontal: 32.0),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      SlideTransition(
                        position: _slideAnimations[0],
                        child: FadeTransition(
                          opacity: _fadeAnimation,
                          child: ScaleTransition(
                            scale: _scaleAnimation,
                            child: Image.asset(
                              "assets/images/logo.png",
                              width: 200,
                              height: 200,
                            ),
                          ),
                        ),
                      ),
                      const SizedBox(height: 20),
                      SlideTransition(
                        position: _slideAnimations[1],
                        child: FadeTransition(
                          opacity: _fadeAnimation,
                          child: CustomText(
                            text: 'TSTH2',
                            colors: ColorConstant.text,
                            size: 32,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      const SizedBox(height: 20),
                      SlideTransition(
                        position: _slideAnimations[2],
                        child: FadeTransition(
                          opacity: _fadeAnimation,
                          child: CustomTextField(
                            label: "Username",
                            controller: _authController.usernameController,
                            isPassword: false,
                            radius: 16.0,
                            keyboardType: TextInputType.name,
                          ),
                        ),
                      ),
                      const SizedBox(height: 20),
                      SlideTransition(
                        position: _slideAnimations[3],
                        child: FadeTransition(
                          opacity: _fadeAnimation,
                          child: CustomTextField(
                            label: "Password",
                            controller: _authController.passwordController,
                            isPassword: true,
                            radius: 16.0,
                            keyboardType: TextInputType.visiblePassword,
                          ),
                        ),
                      ),
                      const SizedBox(height: 50),
                      SlideTransition(
                        position: _slideAnimations[0],
                        child: FadeTransition(
                          opacity: _fadeAnimation,
                          child: CustomButton(
                            text: 'Login',
                            onPressed: () {
                              _authController.login(context);
                            },
                            bgColor: ColorConstant.buttonColor,
                            textColor: ColorConstant.white,
                            width: double.infinity,
                            fontSize: 20,
                            fontWeight: FontWeight.bold,
                          ),
                        ),
                      ),
                      const SizedBox(height: 20),
                    ],
                  ),
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }
}
