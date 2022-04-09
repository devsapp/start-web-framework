"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var __metadata = (this && this.__metadata) || function (k, v) {
    if (typeof Reflect === "object" && typeof Reflect.metadata === "function") return Reflect.metadata(k, v);
};
var __param = (this && this.__param) || function (paramIndex, decorator) {
    return function (target, key) { decorator(target, key, paramIndex); }
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.APIController = void 0;
const decorator_1 = require("@midwayjs/decorator");
const user_service_1 = require("../service/user.service");
let APIController = class APIController {
    async getUser(uid) {
        const user = await this.userService.getUser({ uid });
        return { success: true, message: 'OK', data: user };
    }
};
__decorate([
    decorator_1.Inject(),
    __metadata("design:type", Object)
], APIController.prototype, "ctx", void 0);
__decorate([
    decorator_1.Inject(),
    __metadata("design:type", user_service_1.UserService)
], APIController.prototype, "userService", void 0);
__decorate([
    decorator_1.Get('/get_user'),
    __param(0, decorator_1.Query('uid')),
    __metadata("design:type", Function),
    __metadata("design:paramtypes", [Object]),
    __metadata("design:returntype", Promise)
], APIController.prototype, "getUser", null);
APIController = __decorate([
    decorator_1.Controller('/api')
], APIController);
exports.APIController = APIController;
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBpLmNvbnRyb2xsZXIuanMiLCJzb3VyY2VSb290IjoiL1VzZXJzL3lrL2hlaW1hbmJhL2NuLXNlcnZlcmxlc3Mvc2VydmVybGVzcy9hcHBsaWNhdGlvbi9zdGFydC13ZWItZnJhbWV3b3JrL3dlYi1mcmFtZXdvcmsvbm9kZWpzL2N1c3RvbS1ydW50aW1lL21pZHdheS1rb2Evc3JjL2NvZGUvc3JjLyIsInNvdXJjZXMiOlsiY29udHJvbGxlci9hcGkuY29udHJvbGxlci50cyJdLCJuYW1lcyI6W10sIm1hcHBpbmdzIjoiOzs7Ozs7Ozs7Ozs7Ozs7QUFBQSxtREFBcUU7QUFFckUsMERBQXNEO0FBR3RELElBQWEsYUFBYSxHQUExQixNQUFhLGFBQWE7SUFReEIsS0FBSyxDQUFDLE9BQU8sQ0FBZSxHQUFHO1FBQzdCLE1BQU0sSUFBSSxHQUFHLE1BQU0sSUFBSSxDQUFDLFdBQVcsQ0FBQyxPQUFPLENBQUMsRUFBRSxHQUFHLEVBQUUsQ0FBQyxDQUFDO1FBQ3JELE9BQU8sRUFBRSxPQUFPLEVBQUUsSUFBSSxFQUFFLE9BQU8sRUFBRSxJQUFJLEVBQUUsSUFBSSxFQUFFLElBQUksRUFBRSxDQUFDO0lBQ3RELENBQUM7Q0FDRixDQUFBO0FBVkM7SUFEQyxrQkFBTSxFQUFFOzswQ0FDSTtBQUdiO0lBREMsa0JBQU0sRUFBRTs4QkFDSSwwQkFBVztrREFBQztBQUd6QjtJQURDLGVBQUcsQ0FBQyxXQUFXLENBQUM7SUFDRixXQUFBLGlCQUFLLENBQUMsS0FBSyxDQUFDLENBQUE7Ozs7NENBRzFCO0FBWFUsYUFBYTtJQUR6QixzQkFBVSxDQUFDLE1BQU0sQ0FBQztHQUNOLGFBQWEsQ0FZekI7QUFaWSxzQ0FBYSJ9