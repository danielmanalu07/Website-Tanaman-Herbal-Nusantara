import Admin from "../../domain/models/Admin";
import { AdminRepository } from "../../domain/repositories/AdminRepository";
import { GetProfileAdminUseCase } from "../usecases/Admin/GetProfileAdminUseCase";
import { LoginAdminUseCase } from "../usecases/Admin/LoginAdminUseCase";
import { LogoutAdminUseCase } from "../usecases/Admin/LogoutAdminUseCase";
import Jwt from "../../utils/Jwt";
import Staff from "../../domain/models/Staff";
import { CreateStaffUseCase } from "../usecases/Admin/CreateStaffUseCase";

export class AdminService {
  private loginAdminUseCase: LoginAdminUseCase;
  private getProfileAdminUseCase: GetProfileAdminUseCase;
  private logoutAdminUseCase: LogoutAdminUseCase;
  private createStaffUseCase: CreateStaffUseCase;

  constructor(adminRepository: AdminRepository) {
    this.loginAdminUseCase = new LoginAdminUseCase(adminRepository);
    this.getProfileAdminUseCase = new GetProfileAdminUseCase(adminRepository);
    this.logoutAdminUseCase = new LogoutAdminUseCase(adminRepository);
    this.createStaffUseCase = new CreateStaffUseCase(adminRepository);
  }

  async loginAdmin(
    username: string,
    password: string
  ): Promise<{ admin: Admin; token: string; refreshToken: string } | null> {
    return this.loginAdminUseCase.execute(username, password);
  }

  async getProfile(id: number): Promise<Admin | null> {
    return this.getProfileAdminUseCase.execute(id);
  }

  async logout(id: number): Promise<Admin | null> {
    return this.logoutAdminUseCase.execute(id);
  }

  async refreshToken(refreshToken: string): Promise<any> {
    const decodeAdmin = await Jwt.ExtractRefreshToken(refreshToken);
    if (!decodeAdmin) {
      return null;
    }

    const token = await Jwt.GenerateToken({
      id: decodeAdmin.id,
      username: decodeAdmin.username,
    });

    const result = {
      id: decodeAdmin.id,
      username: decodeAdmin.username,
      token: token,
    };
    return result;
  }

  async createStaff(staff: Staff): Promise<Staff | null> {
    const newStaff = await this.createStaffUseCase.execute(staff);
    await newStaff?.save();
    if (!newStaff) return null;
    return newStaff;
  }
}
