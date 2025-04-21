import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_bloc.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_state.dart';
import 'package:tsth_app/features/validation/presentation/widget/validation_card.dart';
import 'package:tsth_app/routes/initial_route.dart';

class ListValidationScreen extends StatefulWidget {
  const ListValidationScreen({super.key});

  @override
  State<ListValidationScreen> createState() => _ListValidationScreenState();
}

class _ListValidationScreenState extends State<ListValidationScreen> {
  @override
  void initState() {
    context.read<ValidationBloc>().add(LoadValidations());
    super.initState();
  }

  Future<void> _refresh() async {
    await Future.delayed(const Duration(seconds: 2));
    context.read<ValidationBloc>().add(ValidationRefresh());
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: ColorConstant.backgroundColor,
      appBar: AppBar(
        backgroundColor: ColorConstant.backgroundColor,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: ColorConstant.greenColor),
          onPressed: () {
            if (context.canPop()) {
              context.pop();
            } else {
              context.go(InitialRoute.homeScreen);
            }
          },
        ),
        title: const Center(
          child: Text(
            "List Plant Validation",
            style: TextStyle(
              color: ColorConstant.greenColor,
              fontFamily: 'poppins',
              fontWeight: FontWeight.w600,
            ),
          ),
        ),
      ),
      body: BlocBuilder<ValidationBloc, ValidationState>(
        builder: (context, state) {
          if (state is ValidationLoading) {
            return const Center(child: CircularProgressIndicator());
          } else if (state is ValidationLoaded) {
            if (state.validations.isEmpty) {
              return const Center(child: Text('No validations found.'));
            }
            return WillPopScope(
              onWillPop: () async {
                if (context.canPop()) {
                  context.pop();
                } else {
                  context.go(InitialRoute.homeScreen);
                }
                return false;
              },
              child: RefreshIndicator(
                onRefresh: _refresh,
                child: ListView.builder(
                  padding: const EdgeInsets.all(16.0),
                  itemCount: state.validations.length,
                  itemBuilder: (context, index) {
                    final validation = state.validations[index];
                    return ValidationCard(validation: validation);
                  },
                ),
              ),
            );
          } else if (state is ValidationError) {
            return Center(child: Text('Error: ${state.message}'));
          }
          return const Center(child: Text("Refresh to load validations data"));
        },
      ),
    );
  }
}
