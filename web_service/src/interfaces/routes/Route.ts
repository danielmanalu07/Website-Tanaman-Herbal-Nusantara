import express from "express";
import AdminController from "../controllers/AdminController";
import AdminValidation from "../middleware/validation/AdminValidation";
import Authorization from "../middleware/auth/Authorization";

const router = express.Router();

router.post(
  "/auth/admin/login",
  AdminValidation.LoginValidation,
  AdminController.Login
);
router.get(
  "/auth/admin/profile",
  Authorization.Authenticated,
  AdminController.GetProfile
);
router.get(
  "/auth/admin/logout",
  Authorization.Authenticated,
  AdminController.Logout
);
router.get("/auth/admin/refresh-token", AdminController.RefreshToken);

router.post(
  "/admin/create-staff",
  Authorization.Authenticated,
  AdminController.CreateStaff
);
export default router;
