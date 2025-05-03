import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:tsth_app/core/constant/color_constant.dart';
import 'package:tsth_app/features/validation/domain/entities/validation.dart';
import 'package:tsth_app/routes/initial_route.dart';

class ValidationCard extends StatelessWidget {
  final Validation validation;
  const ValidationCard({super.key, required this.validation});

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.only(bottom: 16.0),
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10.0)),
      child: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Row(
          children: [
            Container(
              width: 60,
              height: 60,
              decoration: BoxDecoration(
                borderRadius: BorderRadius.circular(8.0),
                image:
                    (validation.images.isNotEmpty &&
                            validation.images.first.imagePath.isNotEmpty)
                        ? DecorationImage(
                          image: NetworkImage(
                            validation.images.first.imagePath,
                          ),
                          fit: BoxFit.cover,
                        )
                        : null,
              ),
            ),
            const SizedBox(width: 16.0),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    validation.plant?.name ?? 'Unknown Plant',
                    style: const TextStyle(
                      fontSize: 16.0,
                      fontWeight: FontWeight.bold,
                      color: ColorConstant.greenColor,
                    ),
                  ),
                  const SizedBox(height: 4.0),
                  Text(
                    validation.plant?.ecology ?? 'Unknown Ecology',
                    style: const TextStyle(
                      fontSize: 14.0,
                      color: ColorConstant.greenColor,
                      fontWeight: FontWeight.bold,
                    ),
                  ),
                  Row(
                    mainAxisAlignment: MainAxisAlignment.end,
                    children: [
                      InkWell(
                        onTap: () {
                          context.push(
                            InitialRoute.detailValidationScreen.replaceFirst(
                              ':id',
                              validation.id.toString(),
                            ),
                          );
                        },
                        child: Text(
                          "View More...",
                          style: TextStyle(
                            color: ColorConstant.greenColor,
                            fontSize: 14.0,
                            fontWeight: FontWeight.w500,
                          ),
                        ),
                      ),
                    ],
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
