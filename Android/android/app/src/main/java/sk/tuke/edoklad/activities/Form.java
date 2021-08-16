package sk.tuke.edoklad.activities;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import sk.tuke.edoklad.R;

public class Form extends AppCompatActivity implements View.OnClickListener{
    private String email, pass;
    private EditText editPrevadzka, editAdresa, editICO, editICDKP, editCelkom, editDatum, editCas, editDKP;
    private Button odosliNaServer;
    private String prevadzka, adresa, ICO, ICDKP, celkom, dkp, datum, cas;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_form);

        email = getIntent().getStringExtra("email");
        pass = getIntent().getStringExtra("pass");

        TextView textPrevadzka = findViewById(R.id.textPrevadzka);
        editPrevadzka = findViewById(R.id.editPrevadzka);
        TextView textAdresa = findViewById(R.id.textAdresa);
        editAdresa = findViewById(R.id.editAdresa);
        TextView textICO = findViewById(R.id.textICO);
        editICO = findViewById(R.id.editICO);
        TextView textICDKP = findViewById(R.id.textICDKP);
        editICDKP = findViewById(R.id.editICDKP);
        TextView textCelkom = findViewById(R.id.textCelkom);
        editCelkom = findViewById(R.id.editCelkom);
        TextView textDatum = findViewById(R.id.textDatum);
        editDatum = findViewById(R.id.editDatum);
        TextView textCas = findViewById(R.id.textCas);
        editCas = findViewById(R.id.editCas);
        TextView textDKP = findViewById(R.id.textDKP);
        editDKP = findViewById(R.id.editDKP);

        odosliNaServer = findViewById(R.id.odosliNaServer);

        odosliNaServer.setOnClickListener(this);

        try {
            getData();
        } catch (JSONException e) {
            e.printStackTrace();
        }

        editPrevadzka.setText(prevadzka);
        editAdresa.setText(adresa);
        editICO.setText(ICO);
        editICDKP.setText(ICDKP);
        editCelkom.setText(celkom);
        editDatum.setText(datum);
        editCas.setText(cas);
        editDKP.setText(dkp);
    }

    @Override
    public void onClick(View v) {
        if(v == odosliNaServer){
            uploadDataToServer();
            Intent intent = new Intent(this, Dashboard.class);
            intent.putExtra("email", email);
            intent.putExtra("pass", pass);
            startActivity(intent);
        }
    }

    private void getData() throws JSONException {
        String data = getIntent().getStringExtra("odozva").substring(31);

        JSONObject jresponse = new JSONObject(data);
        prevadzka = jresponse.getString("prevadzka");
        adresa = jresponse.getString("adresa");
        ICO = jresponse.getString("ICO");
        ICDKP = jresponse.getString("IC_DKP");
        celkom = jresponse.getString("celkom");
        datum = jresponse.getString("datum");
        cas = jresponse.getString("cas");
        dkp = jresponse.getString("dkp");
    }

    private void uploadDataToServer(){
        RequestQueue queue = Volley.newRequestQueue(this);

        String uploadEnd = "http://147.232.174.113/uploadSafeMobil";
        StringRequest postRequest = new StringRequest(Request.Method.POST, uploadEnd,
                new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        if(response.length()>1) {
                            Toast.makeText(Form.this, "Uprava uspesne nahrana na server", Toast.LENGTH_LONG).show();
                        }
                    }
                },
                new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Log.d("Error.Response", error.toString());
                    }
                }
        ){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<String, String>();
                params.put("email", email);
                params.put("pass", pass);

                String prevadzkaOK = editPrevadzka.getText().toString();
                String adresaOK = editAdresa.getText().toString();
                String ICOOK = editICO.getText().toString();
                String ICDKPOK = editICDKP.getText().toString();
                String celkomOK = editCelkom.getText().toString();
                String datumOK = editDatum.getText().toString();
                String casOK = editCas.getText().toString();
                String dkpOK = editDKP.getText().toString();
                params.put("prevadzka", prevadzkaOK);
                params.put("adresa", adresaOK);
                params.put("ICO", ICOOK);
                params.put("IC_DKP", ICDKPOK);
                params.put("celkom", celkomOK);
                params.put("datum", datumOK);
                params.put("cas", casOK);
                params.put("dkp", dkpOK);

                return params;
            }
            @Override
            public Map<String, String> getHeaders() throws AuthFailureError {
                Map<String,String> params = new HashMap<String, String>();
                params.put("Content-Type","application/x-www-form-urlencoded");
                return params;
            }
        };
        Log.e("VOLEY - KONIEC", postRequest.toString());
        queue.add(postRequest);
    }
}
