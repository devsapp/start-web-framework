"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.NotFoundFilter = void 0;
const decorator_1 = require("@midwayjs/decorator");
const core_1 = require("@midwayjs/core");
let NotFoundFilter = class NotFoundFilter {
    async catch(err, ctx) {
        // 404 错误会到这里
        ctx.redirect('/404.html');
    }
};
NotFoundFilter = __decorate([
    decorator_1.Catch(core_1.httpError.NotFoundError)
], NotFoundFilter);
exports.NotFoundFilter = NotFoundFilter;
//# sourceMappingURL=data:application/json;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoibm90Zm91bmQuZmlsdGVyLmpzIiwic291cmNlUm9vdCI6Ii9Vc2Vycy95ay9oZWltYW5iYS9jbi1zZXJ2ZXJsZXNzL3NlcnZlcmxlc3MvYXBwbGljYXRpb24vc3RhcnQtd2ViLWZyYW1ld29yay93ZWItZnJhbWV3b3JrL25vZGVqcy9jdXN0b20tcnVudGltZS9taWR3YXkta29hL3NyYy9jb2RlL3NyYy8iLCJzb3VyY2VzIjpbImZpbHRlci9ub3Rmb3VuZC5maWx0ZXIudHMiXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6Ijs7Ozs7Ozs7O0FBQUEsbURBQTRDO0FBQzVDLHlDQUE0RDtBQUk1RCxJQUFhLGNBQWMsR0FBM0IsTUFBYSxjQUFjO0lBQ3pCLEtBQUssQ0FBQyxLQUFLLENBQUMsR0FBb0IsRUFBRSxHQUFZO1FBQzVDLGFBQWE7UUFDYixHQUFHLENBQUMsUUFBUSxDQUFDLFdBQVcsQ0FBQyxDQUFDO0lBQzVCLENBQUM7Q0FDRixDQUFBO0FBTFksY0FBYztJQUQxQixpQkFBSyxDQUFDLGdCQUFTLENBQUMsYUFBYSxDQUFDO0dBQ2xCLGNBQWMsQ0FLMUI7QUFMWSx3Q0FBYyJ9