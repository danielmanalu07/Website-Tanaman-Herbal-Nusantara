import 'package:another_flushbar/flushbar.dart';
import 'package:carousel_slider/carousel_slider.dart';
import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_bloc.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_event.dart';
import 'package:tsth_app/features/validation/presentation/bloc/validation_state.dart';
import 'package:tsth_app/features/validation/presentation/screen/update_validation_bottom_sheet.dart';

class DetailValidationScreen extends StatefulWidget {
  final int validationId;
  const DetailValidationScreen({super.key, required this.validationId});

  @override
  State<DetailValidationScreen> createState() => _DetailValidationScreenState();
}

class _DetailValidationScreenState extends State<DetailValidationScreen> {
  @override
  void initState() {
    super.initState();
    context.read<ValidationBloc>().add(
      LoadValidationDetail(widget.validationId),
    );
  }

  Future<void> _refresh() async {
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
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: ColorConstant.greenColor),
          onPressed: () {
            context.read<ValidationBloc>().add(LoadValidations());
            context.pop();
          },
        ),
        centerTitle: true,
        title: const Text(
          "Detail Plant Validation",
          style: TextStyle(
            color: ColorConstant.greenColor,
            fontFamily: 'poppins',
            fontWeight: FontWeight.w600,
            fontSize: 20,
          ),
        ),
      ),
      body: BlocListener<ValidationBloc, ValidationState>(
        listener: (context, state) {
          if (state is ValidationUpdateSuccess) {
            Flushbar(
              message: 'Validation updated successfully',
              duration: const Duration(seconds: 3),
              backgroundColor: ColorConstant.greenColor,
              flushbarPosition: FlushbarPosition.TOP,
            ).show(context);
          }
        },
        child: BlocBuilder<ValidationBloc, ValidationState>(
          builder: (context, state) {
            if (state is ValidationDetailLoading) {
              return const Center(child: CircularProgressIndicator());
            }

            if (state is ValidationError) {
              return Center(
                child: Text(
                  "Failed to load validation: ${state.message}",
                  style: const TextStyle(fontSize: 16, color: Colors.red),
                ),
              );
            }

            if (state is ValidationDetailLoaded) {
              final validation = state.validation;

              return WillPopScope(
                onWillPop: () async {
                  context.read<ValidationBloc>().add(LoadValidations());
                  context.pop();
                  return false;
                },
                child: RefreshIndicator(
                  onRefresh: _refresh,
                  child: SingleChildScrollView(
                    physics: const AlwaysScrollableScrollPhysics(),
                    padding: const EdgeInsets.all(16),
                    child: Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        // Image Carousel
                        if (validation.images.isNotEmpty)
                          Card(
                            elevation: 4,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(12),
                            ),
                            shadowColor: ColorConstant.successColor,
                            color: ColorConstant.backgroundColor,
                            child: CarouselSlider(
                              options: CarouselOptions(
                                height: 200,
                                enlargeCenterPage: true,
                                enableInfiniteScroll: false,
                                viewportFraction: 0.8,
                              ),
                              items:
                                  validation.images.map((image) {
                                    return ClipRRect(
                                      borderRadius: BorderRadius.circular(12),
                                      child: Image.network(
                                        image.imagePath,
                                        fit: BoxFit.cover,
                                        width: double.infinity,
                                        errorBuilder:
                                            (context, error, stackTrace) =>
                                                Container(
                                                  color: Colors.grey[300],
                                                  child: const Center(
                                                    child: Icon(
                                                      Icons.broken_image,
                                                      size: 50,
                                                    ),
                                                  ),
                                                ),
                                      ),
                                    );
                                  }).toList(),
                            ),
                          )
                        else
                          Card(
                            elevation: 4,
                            shape: RoundedRectangleBorder(
                              borderRadius: BorderRadius.circular(12),
                            ),
                            color: ColorConstant.backgroundColor,
                            child: Container(
                              height: 200,
                              width: double.infinity,
                              decoration: BoxDecoration(
                                color: Colors.grey[200],
                                borderRadius: BorderRadius.circular(12),
                              ),
                              child: const Center(
                                child: Text(
                                  'No Images Available',
                                  style: TextStyle(
                                    fontSize: 16,
                                    color: Colors.grey,
                                  ),
                                ),
                              ),
                            ),
                          ),
                        const SizedBox(height: 24),

                        // Plant Information Section
                        Card(
                          elevation: 4,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Padding(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text(
                                  'Plant Information',
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                    color: ColorConstant.greenColor,
                                  ),
                                ),
                                const SizedBox(height: 8),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Plant Name',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(validation.plant?.name ?? '-'),
                                ),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Latin Name',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(
                                    validation.plant?.latinName ?? '-',
                                  ),
                                ),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Habitus',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(
                                    validation.plant?.habitus?.name ?? '-',
                                  ),
                                ),
                              ],
                            ),
                          ),
                        ),
                        const SizedBox(height: 16),

                        // Validation Information Section
                        Card(
                          elevation: 4,
                          shape: RoundedRectangleBorder(
                            borderRadius: BorderRadius.circular(12),
                          ),
                          child: Padding(
                            padding: const EdgeInsets.all(16),
                            child: Column(
                              crossAxisAlignment: CrossAxisAlignment.start,
                              children: [
                                const Text(
                                  'Validation Details',
                                  style: TextStyle(
                                    fontSize: 18,
                                    fontWeight: FontWeight.bold,
                                    color: ColorConstant.greenColor,
                                  ),
                                ),
                                const SizedBox(height: 8),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Date',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(validation.date),
                                ),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Condition',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(validation.condition),
                                ),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Description',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(validation.description),
                                ),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Created At',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(validation.createdAt),
                                ),
                                ListTile(
                                  contentPadding: EdgeInsets.zero,
                                  title: const Text(
                                    'Updated At',
                                    style: TextStyle(
                                      fontWeight: FontWeight.w600,
                                    ),
                                  ),
                                  subtitle: Text(validation.updateAt),
                                ),
                              ],
                            ),
                          ),
                        ),
                        const SizedBox(height: 32),

                        // Update Button
                        SizedBox(
                          width: double.infinity,
                          child: ElevatedButton.icon(
                            icon: const Icon(Icons.edit),
                            label: const Text(
                              "Update Validation",
                              style: TextStyle(fontSize: 16),
                            ),
                            style: ElevatedButton.styleFrom(
                              backgroundColor: ColorConstant.greenColor,
                              foregroundColor: Colors.white,
                              padding: const EdgeInsets.symmetric(vertical: 16),
                              shape: RoundedRectangleBorder(
                                borderRadius: BorderRadius.circular(12),
                              ),
                              elevation: 4,
                            ),
                            onPressed: () {
                              showModalBottomSheet(
                                context: context,
                                isScrollControlled: true,
                                shape: const RoundedRectangleBorder(
                                  borderRadius: BorderRadius.vertical(
                                    top: Radius.circular(20),
                                  ),
                                ),
                                builder:
                                    (context) => Padding(
                                      padding: EdgeInsets.only(
                                        bottom:
                                            MediaQuery.of(
                                              context,
                                            ).viewInsets.bottom,
                                      ),
                                      child: UpdateValidationBottomSheet(
                                        initialValidation: validation,
                                      ),
                                    ),
                              );
                            },
                          ),
                        ),
                      ],
                    ),
                  ),
                ),
              );
            }

            return const SizedBox();
          },
        ),
      ),
    );
  }
}
