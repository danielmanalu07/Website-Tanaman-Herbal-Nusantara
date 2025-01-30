import Admin from "../../../domain/models/Admin";
import { AdminRepository } from "../../../domain/repositories/AdminRepository";
import Password from "../../../utils/Password";
import Token from "../../../utils/Jwt";

export class LoginAdminUseCase {
  constructor(private adminRepository: AdminRepository) {}

  async execute(
    username: string,
    password: string
  ): Promise<{ admin: Admin; token: string; refreshToken: string } | null> {
    const admin = await this.adminRepository.findByUsername(username);
    if (!admin) return null;

    const isPasswordValid = await Password.PasswordCompare(
      password,
      admin.password
    );
    if (!isPasswordValid) return null;

    const dataAdmin = {
      id: admin.id,
      username: admin.username,
    };
    const token = Token.GenerateToken(dataAdmin);
    const refreshToken = Token.GenerateRefreshToken(dataAdmin);

    admin.accessToken = refreshToken;
    await admin.save();

    return { admin, token, refreshToken };
  }
}
