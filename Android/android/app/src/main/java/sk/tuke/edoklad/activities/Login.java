package sk.tuke.edoklad.activities;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import sk.tuke.edoklad.R;

public class Login extends AppCompatActivity implements View.OnClickListener{
    private EditText ET_email, ET_password;
    private String email, password;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        ET_email = (EditText) findViewById(R.id.login_email);
        ET_password = (EditText) findViewById(R.id.login_password);
        Button BTN_login = (Button) findViewById(R.id.login_button_registration);

        BTN_login.setOnClickListener(this);
    }

    public void openDashboard(){
        Intent intent = new Intent(this,Dashboard.class);
        intent.putExtra("email", email);
        intent.putExtra("pass", password);
        startActivity(intent);
    }

    @Override
    public void onClick(View v) {
        userLogin();
    }

    private void userLogin(){
        email = ET_email.getText().toString().trim();
        password = ET_password.getText().toString().trim();
        String LOGIN_URL = String.format("http://147.232.174.113/loginMobil?email=%1$s&password=%2$s", email, password);

        StringRequest stringRequest = new StringRequest(Request.Method.GET, LOGIN_URL,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                            openDashboard();
                    }
                }, new Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {
                Toast.makeText(Login.this, error.toString(), Toast.LENGTH_SHORT).show();
            }
        });
        RequestQueue requestQueue = Volley.newRequestQueue(this);
        requestQueue.add(stringRequest);
    }
}