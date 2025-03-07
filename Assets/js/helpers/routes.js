class Routers {
    static getUrl(route, method) {
        switch (route) {
            case "auth":
                switch (method) {
                    case "setLogin":
                        return `${router}auth/setLogin`;
                    case "setSignup":
                        return `${router}auth/setSignup`;
                    case "resetPassword":
                        return `${router}auth/resetPassword`;

                    default:
                        throw new Error(`El método '${method}' no es válido para la ruta 'auth'.`);
                }
                break; // Agrega un break para el caso "auth"

            case "users":
                return `${router}users`;

            case "payrolls":
                return `${router}payrolls/updatePayroll`;

            case "permissions":
                return `${router}permissions/assignPermissions`;

            default:
                throw new Error("Debe especificar una ruta válida.");
        }
    }
}

export { Routers };

