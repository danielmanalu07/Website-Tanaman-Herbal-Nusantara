import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_bloc.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_state.dart';
import 'package:tsth_app/routes/initial_route.dart';

class DetailValidationScreen extends StatefulWidget {
  final int validationId;
  const DetailValidationScreen({super.key, required this.validationId});

  @override
  State<DetailValidationScreen> createState() => _DetailValidationScreenState();
}

class _DetailValidationScreenState extends State<DetailValidationScreen> {
  @override
  void initState() {
    context.read<ValidationBloc>().add(
      LoadValidationDetail(widget.validationId),
    );
    super.initState();
  }

  Future<void> _refresh() async {
    await Future.delayed(const Duration(seconds: 2));
    context.read<ValidationBloc>().add(
      ValidationDetailRefresh(widget.validationId),
    );
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
        title: Center(
          child: const Text(
            "Detail Plant Validation",
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
          if (state is ValidationDetailLoading) {
            return const Center(child: CircularProgressIndicator());
          } else if (state is ValidationError) {
            return Center(
              child: Text(
                "Failed to load validation details: ${state.message}",
              ),
            );
          } else if (state is ValidationDetailLoaded) {
            final validation = state.validation;
            return WillPopScope(
              onWillPop: () async {
                if (context.canPop()) {
                  context.pop();
                } else {
                  context.go(InitialRoute.listValidationScreen);
                }
                return false;
              },
              child: RefreshIndicator(
                onRefresh: _refresh,
                child: SingleChildScrollView(
                  physics: AlwaysScrollableScrollPhysics(),
                  padding: const EdgeInsets.all(16.0),
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      CarouselSlider(
                        options: CarouselOptions(
                          height: 200.0,
                          enlargeCenterPage: true,
                          enableInfiniteScroll: false,
                          viewportFraction: 0.9,
                          autoPlay: true,
                        ),
                        items:
                            validation.images.map((img) {
                              return Builder(
                                builder: (BuildContext context) {
                                  return ClipRRect(
                                    borderRadius: BorderRadius.circular(10.0),
                                    child: Image.network(
                                      img.imagePath,
                                      fit: BoxFit.cover,
                                      width: double.infinity,
                                      errorBuilder:
                                          (context, error, stackTrace) =>
                                              const Center(
                                                child: Icon(
                                                  Icons.broken_image,
                                                  size: 50,
                                                  color: Colors.grey,
                                                ),
                                              ),
                                      loadingBuilder: (
                                        context,
                                        child,
                                        loadingProgress,
                                      ) {
                                        if (loadingProgress == null)
                                          return child;
                                        return const Center(
                                          child: CircularProgressIndicator(),
                                        );
                                      },
                                    ),
                                  );
                                },
                              );
                            }).toList(),
                      ),
                      const SizedBox(height: 16),
                      Padding(
                        padding: const EdgeInsets.symmetric(horizontal: 10.0),
                        child: Card(
                          margin: const EdgeInsets.only(bottom: 16.0),
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(16.0),
                          ),
                          child: Padding(
                            padding: const EdgeInsets.all(16.0),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              mainAxisAlignment: MainAxisAlignment.center,
                              children: [
                                Text(
                                  "Plant Name: ${validation.plant?.name}",
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                const SizedBox(height: 8.0),
                                Text(
                                  "Latin Name: ${validation.plant?.latinName}",
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                const SizedBox(height: 8.0),
                                Text(
                                  "Habitus: ${validation.plant?.habitus?.name}",
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                const SizedBox(height: 8.0),
                                Text(
                                  "Date: ${validation.date}",
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                const SizedBox(height: 8.0),
                                Text(
                                  "Condition: ${validation.condition}",
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                const SizedBox(height: 8.0),
                                Text(
                                  "Description:",
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                Text(
                                  validation.description,
                                  style: const TextStyle(fontSize: 16.0),
                                ),
                                const SizedBox(height: 24.0),
                                Row(
                                  mainAxisAlignment: MainAxisAlignment.end,
                                  children: [
                                    ElevatedButton.icon(
                                      onPressed: () {
                                        ScaffoldMessenger.of(
                                          context,
                                        ).showSnackBar(
                                          const SnackBar(
                                            content: Text(
                                              "Edit functionality coming soon!",
                                              style: TextStyle(
                                                color: ColorConstant.whiteColor,
                                              ),
                                            ),
                                          ),
                                        );
                                      },
                                      icon: const Icon(
                                        Icons.edit,
                                        color: ColorConstant.whiteColor,
                                      ),
                                      label: const Text(
                                        "EDIT",
                                        style: TextStyle(
                                          color: ColorConstant.whiteColor,
                                        ),
                                      ),
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor:
                                            ColorConstant.greenColor,
                                        padding: const EdgeInsets.symmetric(
                                          horizontal: 24.0,
                                          vertical: 12.0,
                                        ),
                                      ),
                                    ),
                                  ],
                                ),
                              ],
                            ),
                          ),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            );
          }
          return const Center(child: Text("Load validation details"));
        },
      ),
    );
  }
}
