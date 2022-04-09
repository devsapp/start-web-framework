"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.UserService = void 0;
const decorator_1 = require("@midwayjs/decorator");
let UserService = class UserService {
    async getUser(options) {
        return {
            uid: options.uid,
            username: 'mockedName',
            phone: '12345678901',
            email: 'xxx.xxx@xxx.com',
        };
    }
};
UserService = __decorate([
    decorator_1.Provide()
], UserService);
exports.UserService = UserService;
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoidXNlci5zZXJ2aWNlLmpzIiwic291cmNlUm9vdCI6Ii9Vc2Vycy95ay9oZWltYW5iYS9jbi1zZXJ2ZXJsZXNzL3NlcnZlcmxlc3MvYXBwbGljYXRpb24vc3RhcnQtd2ViLWZyYW1ld29yay93ZWItZnJhbWV3b3JrL25vZGVqcy9jdXN0b20tcnVudGltZS9taWR3YXkta29hL3NyYy9jb2RlL3NyYy8iLCJzb3VyY2VzIjpbInNlcnZpY2UvdXNlci5zZXJ2aWNlLnRzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiI7Ozs7Ozs7OztBQUFBLG1EQUE4QztBQUk5QyxJQUFhLFdBQVcsR0FBeEIsTUFBYSxXQUFXO0lBQ3RCLEtBQUssQ0FBQyxPQUFPLENBQUMsT0FBcUI7UUFDakMsT0FBTztZQUNMLEdBQUcsRUFBRSxPQUFPLENBQUMsR0FBRztZQUNoQixRQUFRLEVBQUUsWUFBWTtZQUN0QixLQUFLLEVBQUUsYUFBYTtZQUNwQixLQUFLLEVBQUUsaUJBQWlCO1NBQ3pCLENBQUM7SUFDSixDQUFDO0NBQ0YsQ0FBQTtBQVRZLFdBQVc7SUFEdkIsbUJBQU8sRUFBRTtHQUNHLFdBQVcsQ0FTdkI7QUFUWSxrQ0FBVyJ9