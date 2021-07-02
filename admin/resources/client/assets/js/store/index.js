import Vue from 'vue'
import Vuex from 'vuex'
import Alert from './modules/alert'
import ChangePassword from './modules/change_password'
import Rules from './modules/rules'
import PermissionsIndex from './modules/Permissions'
import PermissionsSingle from './modules/Permissions/single'
import RolesIndex from './modules/Roles'
import RolesSingle from './modules/Roles/single'
import UsersIndex from './modules/Users'
import UsersSingle from './modules/Users/single'
import CategoriesIndex from './modules/Categories'
import CategoriesSingle from './modules/Categories/single'
import TestsIndex from './modules/Tests'
import TestsSingle from './modules/Tests/single'
import EditorSingle from './modules/Tests/editor'
import ResultsIndex from './modules/Results'
import ResultsSingle from './modules/Results/single'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
    modules: {
        Alert,
        ChangePassword,
        Rules,
        PermissionsIndex,
        PermissionsSingle,
        RolesIndex,
        RolesSingle,
        UsersIndex,
        UsersSingle,
        CategoriesIndex,
        CategoriesSingle,
        TestsIndex,
        TestsSingle,
        EditorSingle,
        ResultsIndex,
        ResultsSingle
    },
    strict: debug,
})
