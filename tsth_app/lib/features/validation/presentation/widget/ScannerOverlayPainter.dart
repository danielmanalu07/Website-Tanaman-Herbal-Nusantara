import 'package:flutter/material.dart';

class ScannerOverlayPainter extends CustomPainter {
  final double boxSize;

  ScannerOverlayPainter({this.boxSize = 250});

  @override
  void paint(Canvas canvas, Size size) {
    final paint = Paint()..color = Colors.black.withOpacity(0.5);

    final center = Offset(size.width / 2, size.height / 2);
    final rect = Rect.fromCenter(
      center: center,
      width: boxSize,
      height: boxSize,
    );

    // Buat area gelap
    final outer = Path()..addRect(Rect.fromLTWH(0, 0, size.width, size.height));
    final inner = Path()..addRect(rect);

    // Subtract area kotak scan
    final overlay = Path.combine(PathOperation.difference, outer, inner);
    canvas.drawPath(overlay, paint);
  }

  @override
  bool shouldRepaint(covariant CustomPainter oldDelegate) => false;
}
