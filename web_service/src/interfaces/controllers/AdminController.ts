import { Request, Response } from "express";
import { AdminService } from "../../application/services/AdminService";
import { AdminRepositoryImpl } from "../../infrastructure/repositories/AdminRepositoryImpl";
import Helper from "../../helpers/Failure";
import Staff from "../../domain/models/Staff";

const adminRepository = new AdminRepositoryImpl();
const adminService = new AdminService(adminRepository);

const Login = async (req: Request, res: Response): Promise<void> => {
  try {
    const { username, password } = req.body;
    const result = await adminService.loginAdmin(username, password);
    if (!result) {
      res.status(401).json({
        message: "Invalid Credentials",
      });
      return;
    }
    res.cookie("refreshToken", result.refreshToken, {
      httpOnly: true,
      maxAge: 24 * 60 * 60 * 1000,
    });

    res.status(200).json({
      data: result.admin,
      token: result.token,
    });
  } catch (error: any) {
    res
      .status(500)
      .send(Helper.ResponseError(500, "Internal Server Error", error.message));
  }
};

const GetProfile = async (req: Request, res: Response): Promise<void> => {
  try {
    const adminId = res.locals.userId;
    const admin = await adminService.getProfile(adminId);
    if (!admin) {
      res.status(401).json({
        message: "User Not Found",
      });
      return;
    }
    admin.password = "";
    admin.accessToken = "";

    res.status(200).json({
      status_code: 200,
      message: "Get Data Successfully",
      data: admin,
    });
  } catch (error: any) {
    res
      .status(500)
      .send(Helper.ResponseError(500, "Internal Server Error", error.message));
  }
};

const Logout = async (req: Request, res: Response): Promise<void> => {
  try {
    const refreshToken = req.cookies?.refreshToken;
    if (!refreshToken) {
      res.status(401).json({
        status_code: 401,
        message: "Unauthorized",
      });
      return;
    }

    const adminId = res.locals.userId;
    const admin = await adminService.logout(adminId);
    if (!admin) {
      res.status(401).json({
        message: "User Not Found",
      });
      return;
    }
    await admin.update({ accessToken: null }, { where: { id: adminId } });

    res.clearCookie("refreshToken");
    res.status(200).json({
      status_code: 200,
      message: "Logout Successfully",
    });
  } catch (error: any) {
    res
      .status(500)
      .send(Helper.ResponseError(500, "Internal Server Error", error.message));
  }
};

const RefreshToken = async (req: Request, res: Response): Promise<void> => {
  try {
    const refreshToken = req.cookies?.refreshToken;
    if (!refreshToken) {
      res.status(401).json({
        status_code: 401,
        message: "Unauthorized",
      });
      return;
    }
    const result = await adminService.refreshToken(refreshToken);
    res.status(200).json({
      status_code: 200,
      message: "Refresh Token Successfully",
      data: result,
    });
  } catch (error: any) {
    res
      .status(500)
      .send(Helper.ResponseError(500, "Internal Server Error", error.message));
  }
};

const CreateStaff = async (req: Request, res: Response): Promise<void> => {
  try {
    const { username, password } = req.body;
    const adminId = res.locals.userId;
    const staff = new Staff();
    staff.adminId = adminId;
    const newStaff = await adminService.createStaff(staff);

    if (!newStaff) {
      res
        .status(400)
        .send(Helper.ResponseError(400, "Bad Request", "Failed Create Staff"));
      return;
    }

    res.status(201).json({
      status_code: 201,
      message: "Create Staff Successfully",
      data: newStaff,
    });
  } catch (error: any) {
    res
      .status(500)
      .send(Helper.ResponseError(500, "Internal Server Error", error.message));
  }
};

export default { Login, GetProfile, Logout, RefreshToken, CreateStaff };
